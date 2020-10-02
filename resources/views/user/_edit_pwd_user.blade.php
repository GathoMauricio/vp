@extends('layouts.template')
@section('content')
<h3 class="title_page_vp">
    Cambiar la contraseña de {{ $user->name }} {{ $user->last_name1 }} {{ $user->last_name2 }}
</h3>
<div class="container">
    <form id="frm_edit_pwd_user" action="{{ route('update_pwd_user',$user->id) }}" class="form" method="POST">
        @csrf
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password" class="font-weight-bold">Nueva contraseña</label>
                    <input name="password" type="password" class="form-control"
                        placeholder="Ingrese una contraseña de al menos 6 dígitos...">
                    @if($errors->has('password')) <small
                        style="color:red">{{ $errors->first('password') }}</small>@endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="repassword" class="font-weight-bold">Repetir contraseña</label>
                    <input name="repassword" type="password" class="form-control"
                        placeholder="Repita la nueva contraseña...">
                    @if($errors->has('repassword')) <small
                        style="color:red">{{ $errors->first('repassword') }}</small>@endif
                </div>
            </div>
        </div>

    </form>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <a href="{{ route('edit_user',$user->id) }}" class="btn float-right"
                    style="background-color: #EAECEE">Cancelar</a>
                <button onClick="$('#frm_edit_pwd_user').submit();" type="submit"
                    class="btn btn-primary float-right">Cambiar contraseña</button>
            </div>
        </div>
    </div>
</div>
@endsection