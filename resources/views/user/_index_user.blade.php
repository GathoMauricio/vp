@extends('layouts.template')
@section('content')
<h3 class="title_page_vp">
    Lista de personal
    {{ $users->links() }}
</h3>
@if(count($users) <= 0) @include('layouts.no_records') @endif 
<div class="container">
    <div class="row py-1">
        @foreach($users as $user)
        <div class="col-md-12 py-3 item-service">
            <h5 class="font-weight-bold"> 
                <a href="{{ route('show_user',$user->id) }}" style="color:#87c91f;">
                {{ $user->name }} {{ $user->last_name1 }} {{ $user->last_name2 }} 
                </a>
            </h6>
            <p class="font-weight-bold">
                <img src="{{ env('APP_URL').'/public/storage'.'/'.$user['image'] }}" width="80" height="80" class="py1">
                &nbsp;&nbsp;
                <label style="color:hsl(30, 91%, 61%);">Teléfono: </label>
                {{ $user->phone }}  
                &nbsp;&nbsp;
                <label style="color:#f6993f;">Email: </label>
                {{ $user->email }} 
                <br>
                &nbsp;&nbsp;
                <label style="color:#f6993f;">Dirección: </label>
                {{ $user->calle_numero }} 
                {{ $user->asentamiento }}
                {{ $user->interior }} 
                {{ $user->piso }} 
                {{ $user->cp }}
                {{ $user->estado }} 
                {{ $user->municipio }} 
                {{ $user->ciudad }} 
                <br>
                @php $roles = \App\UserRol::where('user_id',$user->id)->get(); @endphp
                <label style="color:#f6993f;">Roles: </label>
                <table class="table table-striped">
                    <tr>
                        @foreach($roles as $rol)
                        <td style="color:#3498DB;" class="font-weight-bold">{{ $rol->rol_name['rol'] }}</td>
                        @endforeach
                    </tr>
                </table>
            </p>
            <span class="float-right font-weight-bold">Creado el: {{ getFormatDate($user->created_at) }}</span>
            <br>
            <span class="float-right font-weight-bold">Última actualización: {{ getFormatDate($user->updated_at) }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection