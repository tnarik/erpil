@extends('layouts.default')

@section('content')
<div class="container">
  <header style="text-align:center; margin-bottom:50px;">
    @if(isset($site))
    <h1> <a href="/"> {{ $site->name }} </a></h1>
    @else 
    <h1>a new site should be created here</h1>
    @endif
  </header>
  <div class="col-md-4">
    <form action="{{ URL::action('customers.store') }}" method="post" class="form-horizontal">
      @include('customers/partial/customer_form')->withCustomer($customer);
    </form>
    <h2> Registros </h2>
    <div style="height:100px; overflow-y:scroll;">
      <?php
      /*$logs = DB::table('access_log')->where('id_tarjeta', '=', $customer->id_tarjeta);
      setlocale(LC_TIME, 'es_ES'); 
      $logs_ = array(); 
      foreach ($logs->get() as $log){
        $logs_[] = $log;
      }
      foreach (array_reverse($logs_) as $log) {
        $estado = Estado::find($log->status)->nombre;
        echo "Registrado " . $estado . " ($log->extra_data) en " . gmstrftime('%H:%M:%S', strtotime($log->date) +7200 ) . "<br/>";
      }
*/
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
