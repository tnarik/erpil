@extends('layouts.default')

@section('content')
  <div class="col-md-10">
    <ul class="nav nav-justified nav-tabs">
      <li class="active"><a href="">Datos del usuario</a></li>
      <li class=""><a href="{{ URL::action('customers.stats', array($customer->id)) }}">Estadísticas</a></li>
    </ul>

    <form role="form" action="{{ URL::action('customers.update', array($customer->id)) }}" method="POST" class="form-horizontal">
      <input type="hidden" name="_method" value="PUT"/>
      @include('customers/partial/customer_form')->withCustomer($customer)
    </form>
    <div class="col-md-10">
      <h2> Registros </h2>
      <div>
        <?php
          $logs = $customer->events;
          foreach ($logs as $log) {
            $tz = new DateTimeZone('Europe/Madrid');
            $date = $log->created_at;
            $date->setTimeZone($tz);
            $facility_name = Facility::find($log->facility_id)->name;

            echo "[".gmstrftime('%H:%M:%S', strtotime($date) )."] Registrado en " . $facility_name . " : ($log->comment)<br/>";
          }
        ?>
      </div>
    </div>
  </div>


  @unless($current_user)
    <div class="col-md-10">
      <p>Envie este formulario de peticion de membresía en la ciudad de las bicis, será revisado lo antes posible por un administrador.</p>
    </div>
  @endif

@stop
