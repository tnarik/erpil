@extends('layouts.default')

@section('header')
<script>
  function delete_user(id){
    $.ajax({
      url: '/customers/' + id,
      type:'delete',
      success:function(response){
        alert("Usuario borrado correctamente");
        window.location.reload();
      }
    });
  }
</script>
@stop



@section('content')
  <div class="col-md-12">
    <button class="btn btn-lg btn-success" style="margin-bottom: 30px; width:85%;background:dodgerblue" onclick="document.location.href='{{ URL::to('customers/create') }}'">Crear nuevo socio</button>

    <form class="form form-inline" action="{{ URL::action('customers.index') }}" method="GET">
      <input type="text" class="input input-large" value="{{ $search }}" name="search" />
      <input type="hidden" value="{{ $filter }}" name="filter" />
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
      {{ $customers->appends(array('search' => $search, 'filter' => $filter))->links() }}
      @foreach ($customers as $customer)
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
        <a href="{{ URL::action('CustomersController@edit', array($customer->id)) }}">
          <div class="profile_main">
            <div class="profile_img"><img src="/assets/users/sinfoto.jpg" /></div>
            <div class="profile_name">{{ $customer->name }} {{ $customer->surname }}</div>
            <div class="profile_status">
            @unless($customer->verified)
              Pendiente de validar
            @else
              <?php if ($customer->payment_next_date < date('Y-m-d')){
                    echo "Sin pagar";
                  } else {
                    echo "Pagado";
                  }
              ?>
            @endif
              [ {{ $date }} ]
              <a onclick="delete_user({{ $customer->id }});"> Borrar </a>
            </div>
          </div>
        </a>
      @endforeach
      {{ $customers->appends(array('search' => $search, 'filter' => $filter))->links() }}
    @endif
  </div>
@stop
