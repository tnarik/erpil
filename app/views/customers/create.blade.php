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
      @include('customers/partial/customer_form')->withCustomer($customer)->withUser($user);
    </form>
  </div>
  @unless(isset($user))
  <p>
    <?php if (!Auth::check()){ ?>
      Envie este formulario de peticion de membresía en la ciudad de las bicis, será revisado lo antes posible por un administrador.
      <?php } ?>
    </p>
    @endif

    @stop
