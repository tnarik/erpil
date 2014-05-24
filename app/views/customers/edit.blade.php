@extends('layouts.default')

@section('content')
  <div class="col-md-4">
    <form action="{{ URL::action('customers.update', array($customer->id)) }}" method="POST" class="form-horizontal">
      <input type="hidden" name="_method" value="PUT"/>
      @include('customers/partial/customer_form')->withCustomer($customer)->withUser($user);
    </form>
    <h2> Registros </h2>
    <div style="height:100px; overflow-y:scroll;">
      <?php
        $logs = $customer->events;
        foreach ($logs as $log) {
          $tz = new DateTimeZone('Europe/Madrid');
          $date = $log->created_at;
          $date->setTimeZone($tz);
          //$estado = CardEvent::find($log->status)->nombre;
          echo "Registrado " . "en este sitio que viene del Estado ". " ($log->comment) en ". gmstrftime('%H:%M:%S', strtotime($date) ) . "<br/>";
        }
      ?>
    </div>
  </div>
  <div class="col-md-12">DAMN IFRAMES!
    <!--iframe width=100% height=500 seamless src="/home/stats/<?php echo $customer?$customer->id:"false"; ?>/false"></iframe-->
  </div>
  @unless(isset($user))
  <p>
    <?php if (!Auth::check()){ ?>
      Envie este formulario de peticion de membresía en la ciudad de las bicis, será revisado lo antes posible por un administrador.
      <?php } ?>
    </p>
    @endif

@stop
