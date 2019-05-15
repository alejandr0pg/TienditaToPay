@extends('template.app')

@section('title', 'Listado de ordenes')

@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre Cliente</th>
      <th scope="col">Amount</th>
      <th scope="col">Estado</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($orders as $item)
        <tr>
            <th scope="row">
                <a href="{{route('order-detail', ['orderUID' => $item->id])}}">
                    {{ $item->id }}
                </a>
            </th>
            <td>{{ $item->customer_name }}</td>
            <td>{{ $item->amount }}</td>
            <td>{{ $item->status }}</td>
        </tr>
    @endforeach
</tbody>
</table>
@endsection