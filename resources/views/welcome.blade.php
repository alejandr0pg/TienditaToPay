@extends('template.app')

@section('title', $name)

@section('content')
<div class="jumbotron">
  <h1 class="display-4">Bienvenido a <strong>{{ $name }}</strong></h1>
  <p class="lead">Como somos una tienda pequeña, solo tenemos un solo producto.</p>
  <hr class="my-4">
  <p class="mt-2">Tiene un costo de <strong>$1.000 COP</strong>. ¿Deseas comprarlo?</p>
  <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#customerDetail" role="button">Si, deseo comprarlo!</button>
</div>

<!-- Modal -->
<div class="modal fade" id="customerDetail" tabindex="-1" role="dialog" aria-labelledby="customerDetailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="customerForm" action="{{ route('order-generate') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="customerDetailLabel">Información del cliente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="inputName">Nombre</label>
              <input type="text" class="form-control" name="name" id="inputName" 
                placeholder="Nombre" required>
          </div>
          <div class="form-group">
              <label for="inputEmail">Email address</label>
              <input type="email" class="form-control" name="email" id="inputEmail" 
                aria-describedby="emailHelp" placeholder="Enter email" required>
          </div>
          <div class="form-group">
              <label for="inputMobile">Número de celular</label>
              <input type="text" class="form-control" name="phone" id="inputMobile" 
                placeholder="Número de celular" required>
          </div>
          <div class="form-group form-check">
              <input type="checkbox" name="terms" class="form-check-input" id="exampleCheck1" required>
              <label class="form-check-label" for="exampleCheck1">Acepto los terminos y condiciones.</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Continuar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection