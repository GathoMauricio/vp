@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Detalles de cliente</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset('storage/') }}/{{$customer->image}}" alt="{{$customer->image}}" width="80" height="80" style="">
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Nombre / Razón social</label>
                    <br>
                    <span>{{ $customer->name }}</span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Tipo de cliente</label>
                    <br>
                    <span>{{ $customer->customer_type['customer_type'] }}</span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">ID</label>
                    <br>
                    <span>{{ $customer->code }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Responsable</label>
                    <br>
                    <span>{{ $customer->responsable_name }} {{ $customer->responsable_last_name1 }} {{ $customer->responsable_last_name2 }}</span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Teléfono</label>
                    <br>
                    <span>{{ $customer->phone }}</span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Email</label>
                    <br>
                    <span>{{ $customer->email }}</span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Rfc</label>
                    <br>
                    @if(empty($customer->rfc))
                    No definido
                    @else
                    <span>{{ $customer->rfc }}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="" class="font-weight-bold">Dirección</label>
                    <br>
                    <span>
                        {{ $customer->calle_numero }} 
                        {{ $customer->asentamiento }}
                        {{ $customer->cp }} 
                        {{ $customer->ciudad }}
                        {{ $customer->municipio }}
                        {{ $customer->estado }}
                    </span>
                </div>
            </div>
            <div class="row" style="padding:10px;">
                <div class="col-md-4">
                    <br>
                    <a href="{{ route('edit_customer',$customer->id) }}" class="btn btn-warning btn-block">Actualizar</a>
                </div>
                <div class="col-md-4">
                    <br>
                    <a href="{{ route('confirm_customer',$customer->id) }}" class="btn btn-danger btn-block">Eliminar</a>
                </div>
                <div class="col-md-4">
                    <br>
                    <a href="{{ route('index_customer') }}" class="btn btn-block" style="background-color: #EAECEE">Cancelar</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-dark">
                        <tr>
                            <th> <!--Image--></th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>
                                @if($customer['customer_type_id'] > 2 )
                                Descripción
                                @else 
                                Area
                                @endif
                            </th>
                            <th><a href="{{ route('create_final_user',$customer->id) }}"><span class="icon icon-user-plus"></span> Agregar usuario final</a></th>
                        </tr>
                        @if(count($finalUsers)<=0)
                        <tr><td colspan="6"><center>--No se han agregado usuarios finales--</center></td></tr>
                        @else 
                        @foreach($finalUsers as $finalUser)
                        <tr>
                            <td><img src="{{ asset('storage/') }}/{{$finalUser->image}}" alt="{{$customer->image}}" width="80" height="80" style="border-radius:150px;"></td>
                            <td>{{ $finalUser->name }} {{ $finalUser->last_name1 }} {{ $finalUser->last_name2 }}</td>
                            <td>{{ $finalUser->email }}</td>
                            <td>{{ $finalUser->phone }}</td>
                            <td>
                                {{ $finalUser->calle_numero }} 
                                {{ $finalUser->asentamiento }}, 
                                {{ $finalUser->cp }} 
                                {{ $finalUser->ciudad }} 
                                {{ $finalUser->municipio }} 
                                {{ $finalUser->estado }} 
                                @if(!empty($finalUser->piso))
                                Piso {{ $finalUser->piso }} 
                                @endif
                                @if(!empty($finalUser->interior))
                                Int {{ $finalUser->interior }} 
                                @endif
                            </td>
                            <td>{{ $finalUser->area_descripcion }}</td>
                            <td>
                                <a href="{{ route('show_final_user',$finalUser->id) }}" class="btn btn-primary"><span class="icon icon-eye"></span></a>
                                <!--
                                <a href="#" class="btn btn-warning"><span class="icon icon-pencil"></span></a>
                                <a href="#" class="btn btn-danger"><span class="icon icon-bin"></span></a>
                                -->
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection