@extends('layouts.default')

@section('header')
<script src="html5-canvas-bar-graph.js"></script>
@stop

@section('content')
<div class="col-md-10">
  <ul class="nav nav-justified nav-tabs">
    <li><a href="{{ URL::action('customers.edit', array($customer->id)) }}">Datos del usuario</a></li>
    <li class="active"><a href="">Estadísticas</a></li>
  </ul>


  @foreach( array ( 'LIBRARY', 'WSHOP' , 'PARKING') as $elem )
  <div class="container">
    <h2 style="text-transform:uppercase">{{ Facility::whereCode($elem)->first()->name }}</h2>
    <div class="col-md-6">
      <h3> Estadisticas por dia </h3>
      <canvas id="days_{{ $elem }}"></canvas>
    </div>
    <div class="col-md-6">
      <h3> Estadisticas por hora </h3>
      <canvas id="hours_{{ $elem }}"></canvas>
    </div>
  </div>
  <script>
    var ctx = document.getElementById("days_{{ $elem }}").getContext("2d");
    var graph = new BarGraph(ctx);
    graph.margin = 2;
    graph.colors = ["#fff"];
    graph.width = 450;
    graph.height = 150;
    graph.xAxisLabelArr = ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];
    graph.update([{{ implode(',', $stats[$elem]['days']) }}]);

    var ctx = document.getElementById("hours_{{ $elem }}").getContext("2d");
    var graph = new BarGraph(ctx);
    graph.margin = 2;
    graph.colors = ["#fff"];
    graph.width = 450;
    graph.height = 150;
    graph.xAxisLabelArr = [<?php echo implode(',', array_keys($stats[$elem]['hours'])); ?>];
    graph.update([<?php echo implode(',', $stats[$elem]['hours']); ?>]);
  </script>
  @endforeach
</div>
@stop
