<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrdersController extends Controller
{
    //
    public function getAllOrders(Request $request)
    {
        $orders = Order::all();

        return view('orders.all', compact('orders'));
    }

    public function getOrderByUid(Request $request, $uid)
    {
        $order = Order::where('uid', '==', $uid)->firstOrFail();

        return view('orders.detail', compact('order'));
    }

    public function generateOrder(Request $request)
    {
        // Generamos la orden
        $order = new Order;
        $order->customer_name = $request->name;
        $order->customer_email = $request->email;
        $order->customer_mobile = $request->phone;
        $order->save();

        // Payment data
        $seed = date('c');
        $nonce = $this->generateNonce();
        $secretKey = '024h1IlD';
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));
        $paymentData = [
            'auth' => [
                'login' => '6dd490faf9cb87a9862245da41170ff2',
                'seed' => $seed,
                'nonce' => base64_encode($nonce),
                'tranKey' => $tranKey
            ],
            'payment' => [
                'reference' => $order->id,
                'description' => 'Pago del unico producto de la tienda #' . $order->id,
                'amount' => [
                    'currency' => 'COP',
                    'total' => '1000'
                ]
            ],
            'expiration' => date('c', time() + 3600), // +1h
            'returnUrl' => route('process-pay', ['ref' => $order->id]),
            'ipAddress' => $request->ip() != "::1" ? $request->ip() : '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.82 Safari/537.36'
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://dev.placetopay.com/redirection/api/session', [
            'json' => $paymentData
        ]);
        
        // Decodificamos la respuesta
        $json = json_decode($response->getBody());
        
        // Verificamos el estado de la respuesta
        if($json->status->status === 'OK') {
            $order->pay_reference = $json->requestId;
            $order->pay_url = $json->processUrl;
            $order->save();
            //
            return redirect($json->processUrl);
        } else {
            // Devolvemos al usuario y mostramos el mensaje de error.
            return redirect()->back()->with('Error', $json->status->message);
        }
    }

    public function processPay(Request $request)
    {
        // Obtenemos la orden
        $order = Order::findOrFail($request->ref);
        $order->status = 'PAYED';
        $order->save();

        return redirect()->route('order-detail', ['orderUID' => $order->id]);
    }

    public function generateNonce() {
        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }
        //
        return $nonce;
    }
}
