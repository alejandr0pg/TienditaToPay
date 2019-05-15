@extends('template.app')

@section('title', 'Orden de compra #' . $order->id)

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header">
			Orden <strong>#{{$order->id}}</strong> 
			<span class="float-right"> <strong>Estado:</strong> {{$order->status}}</span>
		</div>
		<div class="card-body">
			<div class="table-responsive-sm">
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="center">#</th>
							<th>Item</th>
							<th>Description</th>
							<th class="right">Unit Cost</th>
							<th class="center">Qty</th>
							<th class="right">Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="center">1</td>
							<td class="left strong">Unique</td>
							<td class="left">Unique product</td>
							<td class="right">$10.000 COP</td>
							<td class="center">1</td>
							<td class="right">$10.000 COP</td>
						</tr>
					</tbody>
				</table>
			</div>
			@if($order->status === 'PENDING')
				<a class="btn btn-primary btn-lg btn-block" href="{{ $order->pay_url }}">PAGAR</a>
			@endif
			@if($order->status === 'REJECTED')
				<a class="btn btn-primary btn-lg btn-block" href="{{ route('home') }}">Volver a intentarlo</a>
			@endif
		</div>
	</div>
</div>
@endsection