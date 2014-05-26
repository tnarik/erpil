@extends('layouts.default')

@section('header')
<script>
  function marcarLibro(){
    $.ajax({
      url: '{{ URL::to('events') }}',
      type:'POST',
      data:{
        'facility' : 'LIBRARY',
        'card_id' : prompt('Ponga la tarjeta en el lector'),
        'comment' : prompt("Introduzca la referencia del libro: ")
      },
      success:function(response){
        alert("listo");
      },
      error:function(){
        alert('esta tarjeta no esta registrada');
      }
    });
  }

  function marcarTaller(){
    $.ajax({
      url: '{{ URL::to('events') }}',
      type:'POST',
      data:{
        'facility' : 'WSHOP',
        'card_id' : prompt('Ponga la tarjeta en el lector'),
        'comment' : prompt("Introduzca un comentario al respecto: ")
      }
    });
  }
</script>
@stop



@section('content')
{{ CardEvent::all(); }}
<div class="col-md-13">
  <div role="main" class="col-md-4">
    <fieldset>
      <legend>Gestion de usuarios</legend>
      <a href="{{ URL::action('customers.index') }}">
        <div class="well" style="text-align:right">
          <h1 style="float:left; padding-top:30px"> Gestionar </h1>
          <img style="text-align:right" src="assets/users/sinfoto.jpg" />
        </div>
      </a>
      <p>
        Acceso al sistema de gestión de usuarios.
        Desde aquí podrá
      </p>
    </fieldset>
  </div>

  <div role="main" class="col-md-4">
    <fieldset>
      <legend>Estadisticas de acceso</legend>
      <div class="well">
        <a href="/home/stats/">
          {{ image_tag('stats.png', array( 'class' => 'img-responsive' )  ) }}
        </a>
      </div>
      <p>Estadisticas recopiladas de acceso al almacen de bicis</p>
    </fieldset>
  </div>

  <div role="main" class="col-md-4">
    <fieldset>
      <legend>Marcar inicio/fin de taller</legend>
      <a href="#" onclick="marcarTaller();return false">
        <div class="well" style="text-align:right">
          <h1 style="float:left; padding-top:30px"> Taller </h1>
          <img style="text-align:right" src="assets/users/sinfoto.jpg" />
        </div>
      </a>
      <p>
        Pasa la tarjeta despues de pulsar este boton para
        registrar cuando un usuario entra y sale del taller.
        Estos datos saldran en el registro del usuario.
      </p>
    </fieldset>
  </div>

  <div role="main" class="col-md-4">
    <fieldset>
      <legend>Marcar prestamo/devolucion de libro</legend>
      <a href="" onclick="marcarLibro(); return false">
        <div class="well" style="text-align:right">
          <h1 style="float:left; padding-top:30px"> Libro </h1>
          <img style="text-align:right" src="assets/users/sinfoto.jpg" />
        </div>
      </a>
      <p>
        Pasa la tarjeta despues de pulsar este boton para
        registrar cuando un usuario coje un libro..
        Estos datos saldran en el registro del usuario.
      </p>
    </fieldset>
  </div>

  <div role="main" class="col-md-4">
    <fieldset>
      <legend>Apertura remota de puerta</legend>
      <a href="{{ URL::route('door') }}" onclick="if(!confirm('¿Está seguro de que quiere abrir la puerta?')){ return false; }" >
        <div class="well" style="text-align:right">
          <h1 style="float:left; padding-top:30px"> Abrir  </h1>
          <img style="text-align:right" src="assets/unlock.png" />
        </div>
      </a>
      <p>
        Abre la puerta. Este sistema puede usarse para abrir la puerta desde dentro de la oficina
        o desde fuera, con un smartphone y las credenciales adecuadas
      </p>
    </fieldset>
  </div>

</div>
@stop
