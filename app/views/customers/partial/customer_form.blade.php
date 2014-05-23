<script>
  function validar(){
    document.getElementById('status').value = 1;
    alert("Usuario marcado para validar. Pulse enviar para aplicar los cambios");
  }
  function assign_card(){
    document.getElementById('id_tarjeta').value = prompt('Coloque la tarjeta sobre el lector');
    alert("Tarjeta asociada correctamente. Pulse enviar para aplicar los cambios");
  }
  function unassign_card(){
    document.getElementById('id_tarjeta').value = "";
    alert("Tarjeta anulada correctamente. Pulse enviar para aplicar los cambios");
  }
</script>
  <input type=hidden name=id_tarjeta id=id_tarjeta value="{{ $customer->id_tarjeta  }}" />
  <input type=hidden value="{{ $customer->status }}" name=status id=status />
  <?php
  $props=array(
  'E-mail' => 'email',
  'Nombre' => 'name',
  'Apellidos' => 'surname',
  'DNI' => 'dni',
  'Teléfono' => 'phone',
  'Dirección' => 'address',
  'Forma de pago' => 'payment',
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
  @if(isset($customer))
  <img src="/img/users/{{ $customer->id }}"/><br/>
  @endif
  @if(isset($user))
  <br/><button class="btn btn-success btn-big" onclick="assign_card(); return false"> Asociar tarjeta </button><br/>
  <button class="btn btn-success btn-big" onclick="unassign_card(); return false"> Anular tarjeta </button><br/>
  <br/>
  @if(isset($customer->id_tarjeta))
  {{ $customer->id_tarjeta }}<div class='alert alert-info'>Tarjeta asociada actualmente : {{ $customer->id_tarjeta }}</div>"
  @endif

  @if(!$customer->status)
  <div class='alert alert-info'>Usuario no validado <button onclick="validar(); return false" class="btn btn-warning"> Validar usuario </button>
  </div>
  @elseif ( $customer->fechapago < date('Y-m-d'))
  <div class="alert alert-danger"> Este usuario tiene un pago pendiente
    <label> Introduzca una nueva fecha de vencimiento del pago</label>
    <input type="date" name=fechapago value="<?= $customer->fechapago ?>" style="display:-webkit-inline-box">
  </div>
  @else
  <div class='alert alerf-info'>Usuario pagado hasta: $customer->fechapago<br/><br/>
    <input type="date" name=fechapago value="'.$customer->fechapago.'" style="display:-webkit-inline-box"></div>
    @endif
  </div>
  <hr>
  @endif