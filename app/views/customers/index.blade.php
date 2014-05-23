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
<div class="container">
  <header style="text-align:center; margin-bottom:50px;">
    @if(isset($site))
      <h1> <a href="/"> {{ $site->name }} </a></h1>
    @else 
      <h1>a new site should be created here</h1>
    @endif
  </header>
  <div class="col-md-6">
    <form class="form form-inline" action="{{ URL::action('customers.index') }}" method="GET">
      <input type="text" class="input input-large" name="search" />
      <button class="btn btn-primary btn-medium"> Buscar </button>
      <br/>
    </form>
    <button class="btn btn-large btn-success" style="width:85%;background:dodgerblue" onclick="document.location.href='{{ URL::to('customers/create') }}'">Nuevo</button>
    <br/>
    <button class="btn btn-large btn-success" onclick="location.href='/customers';">Todos</button>
    <button class="btn btn-large btn-warning" onclick="location.href='/customers?search=aa1';">P. validar</button>
    <button class="btn btn-large btn-danger" onclick="location.href='/customers?search=aa2';">P. pago</button>
    <button class="btn btn-large btn-success" onclick="location.href='/customers?search=aa3';">P. devolucion libro</button> 
    <br/>

    @if(isset($customers))
      {{ $customers->appends(array('search' => Input::get('search')))->links() }}
      @foreach ($customers as $customer)
      <?php
        //$logs = DB::table('access_log')->where('id_tarjeta', '=', $customer->id_tarjeta);
        //$lastlog = $logs->order_by('date', 'desc')->take(1)->first();
        //$lastlog = $lastlog?$lastlog->date:false;
        ?>
        <a href="{{ URL::action('CustomersController@edit', array($customer->id)) }}">
          <div class="profile_main">
            <div class="profile_img"><img src="assets/users/sinfoto.jpg" /></div>
            <div class="profile_name">{{ $customer->name }} {{ $customer->surname }}</div>
            <div class="profile_status"><?php
              if (!$customer->status){
                echo "Pendiente de validar";
              } else {
                if ($customer->fechapago < date('yyyy-mm-dd')){
                  echo "Sin pagar";
                } else {
                  echo "Pagado";
                }
              }
              echo " - ";
              //echo $lastlog?$lastlog:"Nunca ha accedido";
              ?>
              <a onclick="delete_user({{ $customer->id }});"> Borrar </a>
            </div>
          </div>
        </a>
      @endforeach
      {{ $customers->appends(array('search' => Input::get('search')))->links() }}
    @endif
  </div>
  <div class="col-md-6">
    DAMN IFRAMES!!!
    <!--iframe width=100% height=500 seamless src="/home/stats/false/false"></iframe-->
  </div>
</div>
@stop
