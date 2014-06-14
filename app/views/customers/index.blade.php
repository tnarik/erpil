@extends('layouts.default')

@section('header')
<script>
  function refresh_order(order_type){
    window.location.replace("{{ URL::action('customers.index', [ 'filter' => $filter, 'search' => $search, 'order' => '']) }}"+order_type);
  }
</script>
@stop



@section('content')
  <div class="col-md-12">
    <button class="btn btn-lg btn-success" style="margin-bottom: 30px; width:85%;background:dodgerblue" onclick="document.location.href='{{ URL::to('customers/create') }}'">Crear nuevo socio</button>

    <form class="form form-inline" action="{{ URL::action('customers.index') }}" method="GET">
      <input type="text" class="input input-large" value="{{ $search }}" name="search" />
      <input type="hidden" value="{{ $filter }}" name="filter" />
      <input type="hidden" value="{{ $order }}" name="order" />
      <button class="btn btn-primary"> Buscar </button>
      <br/>
    </form>
    <ul class="nav nav-justified nav-tabs" style="padding-top: 50px;">
      <li class="{{ ($filter == '') ? 'active' : '' }}"><a href="/customers">Todos</a></li>
      <li class="{{ ($filter == 'unverified') ? 'active' : '' }}"><a href="/customers?filter=unverified">Pendiente de validar</a></li>
      <li class="{{ ($filter == 'pending_payment') ? 'active' : '' }}"><a href="/customers?filter=pending_payment">Pendiente de pago</a></li>
      <li class="{{ ($filter == 'pending_books') ? 'active' : '' }}"><a href="/customers?filter=pending_books">Pendiente de devolución de libro</a></li>
    </ul>

    @if(isset($customers))
      {{ $customers->appends(array('search' => $search, 'filter' => $filter, 'order' => $order ))->links() }}
      <div class="panel">
      @if ( count($customers) > 0 )
        <table class="table">
          <thead>
            <tr>
              <th class="profile_img_header"></th>
              <th class="col-md-2" onclick="refresh_order('name');"><span class="glyphicon {{ ($order == 'name') ? (($direction == 'asc') ? 'glyphicon-chevron-up' : 'glyphicon-chevron-down' ): '' }}" /></span> Nombre</th>
              <th class="col-md-4" onclick="refresh_order('surname');"><span class="glyphicon {{ ($order == 'surname') ? (($direction == 'asc') ? 'glyphicon-chevron-up' : 'glyphicon-chevron-down' ): '' }}"/></span> Apellidos</th>
              <th onclick="refresh_order('customer_id');"><span class="glyphicon {{ ($order == 'customer_id') ? (($direction == 'asc') ? 'glyphicon-chevron-up' : 'glyphicon-chevron-down' ): '' }}"/></span> Número de socio</th>
              <th>Estado</th>
              <th><span class="glyphicon"/></span> Último acceso</th>
            </tr>
          <thead>
          <tbody>
            @foreach ($customers as $customer)
              <tr class="profile_main">
                <?php
                 $log = $customer->events->last();
                  $tz = new DateTimeZone('Europe/Madrid');
                  if ( $log ) {
                    $date = $log->created_at;
                    $date->setTimeZone($tz);
                  } else {
                    $date = "Nunca ha accedido";
                 }
                ?>
                <td>
                  <a href="{{ URL::action('CustomersController@edit', array($customer->id)) }}">
                    <div class="profile_img"><img src="/assets/users/sinfoto.jpg" /></div>
                  </a>
                </td>
                <td>
                  <a href="{{ URL::action('CustomersController@edit', array($customer->id)) }}">
                    <div class="profile_name">{{ $customer->name }}</div>
                  </a>
                </td>
                <td>
                  <a href="{{ URL::action('CustomersController@edit', array($customer->id)) }}">
                    <div class="profile_name">{{ $customer->surname }}</div>
                  </a>
                </td>
                <td>{{ $customer->customer_id }}</td>
                <td>
                  @unless($customer->verified)
                    Pendiente de validar
                  @else
                    @if ($customer->payment_next_date < date('Y-m-d'))
                      Sin pagar
                    @else
                      Pagado
                    @endif
                  @endif
                </td>
                <td>{{ $date }}</td>
                <!--td><a onclick="delete_user({{ $customer->id }});"> Borrar </a></td-->
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        No hay socios en esta categoría
      @endif
      </div>
      {{ $customers->appends(array('search' => $search, 'filter' => $filter, 'order' => $order ))->links() }}
    @endif
  </div>
@stop
