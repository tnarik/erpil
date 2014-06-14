@extends('layouts.default')


@section('content')
<div class="col-md-12">
    <div role="main" class="col-md-4">
        <form action="{{ URL::route('sessions.store') }}" method="POST" class="form-horizontal">
            <fieldset>
                <legend>Inicio de sesión</legend>
                
                @if(isset($first))
                <div><span>This is the first login to the system. These credentials will be used to set the first user entry.</span></div>
                @endif
                <div class="form-group">
                    <label class="control-label" for="email">Correo electrónico</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"/></span></span>
                            <input name="email" type="email" placeholder="lacicleria@lacicleria.com" value="{{ Input::old('email') }}" class="form-control" />
                        </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="user">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"/></span></span>
                            <input name="password" type="password" placeholder="password" class="form-control" />
                        </div>
                </div>

                <div style="text-align:center">
                    <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>

@stop