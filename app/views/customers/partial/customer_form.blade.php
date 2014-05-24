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
  <input type='hidden' name='card_id' id='card_id' value="{{ $customer->card_id  }}" />
  <input type='hidden' value="{{ $customer->verified }}" name='verified' id='verified' />
  <?php
  $props=array(
  'E-mail' => 'email',
  'Nombre' => 'name',
  'Apellidos' => 'surname',
  'DNI' => 'dni',
  'Teléfono' => 'phone',
  'Dirección' => 'address',
  'Forma de pago' => 'payment_method',
  'Numero de socio' => 'associateno',
  'Comentario' => 'comment',
  );

  foreach ($props as $name => $prop){ ?>
  <div class="control-group">
    <label class="control-label" for="<?php echo $prop; ?>">
      <?php echo $name?>
    </label>
    <div class="controls">
      <input type="text" name=<?php echo $prop; ?>
      value="<?php echo $customer?$customer->$prop:'';?>" placeholder="<?php echo $prop?>"/>
    </div>
  </div>
  <?php } ?>
  <div class="control-group">
    <label class="control-label" for="has_parking"> ¿Tiene acceso al parking?
    </label>
    <div class="controls">
      <input type="checkbox" name=has_parking {{ $customer->has_parking?"checked":"";  }} value=1 />
    </div>
  </div>
</div>
<div class="col-md-4">
  <button style="width:100%;" type=submit class="btn btn-big btn-success"> Enviar </button>
</div>
<div class="col-md-4" style="margin-left:120px">
  <!--
  @if(isset($customer))
  <img src="/img/users/{{ $customer->id }}"/><br/>
  @endif
  -->
  @if(isset($user))
  <br/><button class="btn btn-success btn-big" onclick="assign_card(); return false"> Asociar tarjeta </button><br/>
  <button class="btn btn-success btn-big" onclick="unassign_card(); return false"> Anular tarjeta </button><br/>
  <br/>
  @if(isset($customer->card_id))
  <div class='alert alert-info'>Tarjeta asociada actualmente : {{ $customer->card_id }}</div>"
  @endif

  @unless($customer->verified)
  <div class='alert alert-info'>Usuario no validado <button onclick="validar(); return false" class="btn btn-warning"> Validar usuario </button>
  </div>
  @elseif ( $customer->payment_next_date < date('Y-m-d'))
  <div class="alert alert-danger"> Este usuario tiene un pago pendiente
    <label> Introduzca una nueva fecha de vencimiento del pago</label>
    <input type="date" name='payment_next_date' value="{{ $customer->payment_next_date }}" style="display:-webkit-inline-box">
  </div>
  @else
  <div class='alert alerf-info'>Usuario pagado hasta: {{ $customer->payment_next_date }}<br/><br/>
    <input type="date" name='payment_next_date' value="{{ $customer->payment_next_date }}" style="display:-webkit-inline-box"></div>
    @endif
  </div>
  <hr>
  @endif