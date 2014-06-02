<script>
  function validar(){
    document.getElementById('verified').value = 1;
    alert("Usuario marcado para validar. Pulse enviar para aplicar los cambios");
  }
  function assign_card(){
    document.getElementById('card_id').value = prompt('Coloque la tarjeta sobre el lector');
    alert("Tarjeta asociada correctamente. Pulse enviar para aplicar los cambios");
  }
  function unassign_card(){
    document.getElementById('card_id').value = "";
    alert("Tarjeta anulada correctamente. Pulse enviar para aplicar los cambios");
  }
</script>
<div class="col-md-6">
  <input type='hidden' name='card_id' id='card_id' value="{{ $customer->card_id  }}" />
  <input type='hidden' value="{{ $customer->verified }}" name='verified' id='verified' />
  <div class="form-group">
  <label class="col-md-2 control-label" for="email">E-mail</label>
    <input class="col-md-4" type="text" name="email" value="{{ $customer->email }}" placeholder="email"/>
  </div>
  <div class="form-group">
  <label class="col-md-2 control-label" for="name">Nombre</label>
    <input class="col-md-4" type="text" name="name" value="{{ $customer->name }}" placeholder="nombre"/>
  </div>
  <div class="form-group">
  <label class="col-md-2 control-label" for="surname">Apellidos</label>
    <input class="col-md-4" type="text" name="surname" value="{{ $customer->surname }}" placeholder="apellidos"/>
  </div>
  <div class="form-group">
  <label class="col-md-2 control-label" for="national_id">DNI</label>
    <input class="col-md-4" type="text" name="national_id" value="{{ $customer->national_id }}" placeholder="DNI"/>
  </div>
  <div class="form-group">
  <label class="col-md-2 control-label" for="phone">Teléfono</label>
    <input class="col-md-4" type="text" name="phone" value="{{ $customer->phone }}" placeholder="Teléfono"/>
  </div>
  <div class="form-group">
  <label class="col-md-2 control-label" for="address">Dirección</label>
    <input class="col-md-4" type="text" name="address" value="{{ $customer->address }}" placeholder="Dirección"/>
  </div>
  <div class="form-group">
  <label class="col-md-2 control-label" for="payment_method">Forma de pago</label>
    <input class="col-md-4" type="text" name="payment_method" value="{{ $customer->payment_method }}" placeholder="Forma de pago"/>
  </div>
  <div class="form-group">
  <label class="col-md-2 control-label" for="comment">Comentario</label>
    <input class="col-md-4" type="text" name="comment" value="{{ $customer->comment }}" placeholder="Comentario"/>
  </div>
  <div class="form-group">
  <label class="col-md-2 control-label" for="has_parking">¿Tiene acceso al parking?</label>
    <input type="checkbox" name="has_parking" {{ $customer->has_parking?"checked":"";  }} value="1" />
  </div>
</div>

<div class="col-md-4" style="margin-left:80px">

  <div>
   <button style="width:100%;" type="submit" class="btn btn-big btn-success">Enviar</button>
  </div>


  @if($current_user)
  <br/><button class="btn btn-success btn-big" onclick="assign_card(); return false"> Asociar tarjeta </button><br/>
  <button class="btn btn-success btn-big" onclick="unassign_card(); return false"> Anular tarjeta </button><br/>
  <br/>
  @if(isset($customer->card_id))
  <div class='alert alert-info'>Tarjeta asociada actualmente : {{ $customer->card_id }}</div>
  @endif

  @unless($customer->verified)
  <div class='alert alert-info'>Usuario no validado <button onclick="validar(); return false" class="btn btn-warning"> Validar usuario </button>
  </div>
  @elseif ( $customer->payment_next_date < date('Y-m-d'))
  <div class="alert alert-danger"> Este usuario tiene un pago pendiente
    <label> Introduzca una nueva fecha de vencimiento del pago</label>
    <input type="date" name='payment_next_date' value="{{ $customer->payment_next_date }}">
  </div>
  @else
  <div class='alert alerf-info'>Usuario pagado hasta: {{ $customer->payment_next_date }}<br/><br/>
    <input type="date" name='payment_next_date' value="{{ $customer->payment_next_date }}"></div>
    @endif
  @endif
</div>
  <hr>
