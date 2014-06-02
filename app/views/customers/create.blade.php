@extends('layouts.default')

@section('content')
  <div class="col-md-10">
    <form role="form" action="{{ URL::action('customers.store') }}" method="post" class="form-horizontal">
      @include('customers/partial/customer_form')->withCustomer($customer);
    </form>
  </div>
  @unless($current_user)
    <div class="col-md-10">
      <p>Envie este formulario de peticion de membresía en la ciudad de las bicis, será revisado lo antes posible por un administrador.</p>
    </div>
  @endif

@stop
