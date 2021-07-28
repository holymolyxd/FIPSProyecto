@extends('admin.master')

@section('title', 'Editar Usuarios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users/1') }}"><i class="fas fa-users"></i> Usuarios</a>
    </li>

    <li class="breadcrumb-item">
        <a href="{{ url('/admin/user/'.$u->id.'/edit') }}"><i class="fas fa-user"></i> Tipo de Usuario: {{ $u->name }} (ID: {{ $u->id }})</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page_user">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-user-edit"></i> Información del Usuario</h2>
                        </div>

                        <div class="inside">
                            <div class="mini_profile">
                                @if(is_null($u->avatar))
                                    <img src="{{ url('/static/images/default_avatar.jpg') }}" alt="" class="avatar">
                                @else
                                    <img src="{{ url('/uploads/user/'.$u->id.'/'.$u->avatar) }}" alt="" class="avatar">
                                @endif

                                <div class="info">
                                    <span class="title"><i class="fas fa-fingerprint"></i> RUT:</span>
                                    <span class="text">{{ Rut::parse($u->rut)->format() }}</span>
                                    <span class="title"><i class="far fa-address-card"></i> Nombre:</span>
                                    <span class="text">{{ $u->name }}</span>
                                    <span class="title"><i class="fas fa-venus-mars"></i> Genero:</span>
                                    <span class="text">{{ $u->gender->name }}</span>
                                    <span class="title"><i class="far fa-envelope"></i> Email:</span>
                                    <span class="text">{{ $u->email }}</span>
                                    <span class="title"><i class="fas fa-phone"></i> Telefono:</span>
                                    <span class="text">{{ is_null($u->phone) ? 'Sin informacion' : $u->phone }}</span>
                                    <span class="title"><i class="fas fa-birthday-cake"></i> Fecha de nacimiento:</span>
                                    <span class="text">{{ is_null($u->birthdate) ? 'Sin informacion' : date('d/m/Y', strtotime($u->birthdate)) }}</span>
                                    <span class="title"><i class="far fa-calendar-alt"></i> Fecha de registro:</span>
                                    <span class="text">{{ $u->created_at->format('d/m/Y') }}</span>
                                    <span class="title"><i class="fas fa-user-shield"></i> Tipo de usuario:</span>
                                    @foreach($u->roles as $role)
                                        <span class="text">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-edit"></i> Editar Usuario</h2>
                        </div>

                        <div class="inside">
                            <form method="POST" action="{{ url('/admin/user/'.$u->id.'/edit') }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="rol">Tipo de usuario:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-keyboard"></i>
                                                </span>
                                            </div>
                                            <select name="rol" id="rol" class="selectpicker form-control" title="Selecciona una opción" data-size="4">
                                                @foreach($r as $role)
                                                    <option value="{{$role->id}}" {{$u->hasRole($role->slug) ? 'selected' : ''}}>{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8" style="margin-top: 30px;">
                                        <input type="submit" value="Guardar" class="btn btn-success">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel shadow mtop16">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-address-card"></i> Permisos de Usuario</h2>
                        </div>
                        <div class="inside">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <caption>Cantidad de permisos listados: {{ $up->count() }} @if($up->count() > 1 || $up->count() == 0 ) permisos. @else permiso. @endif</caption>
                                        <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>Nombre</td>
                                            <td>Fecha de asignación</td>
                                            <td>Tiempo de asignación</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($up as $permission)
                                            <tr>
                                                <td>{{ $permission->id }}</td>
                                                <td>{{ $permission->name }}</td>
                                                <td>{{ $permission->pivot->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $permission->pivot->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tr>
                                            <td colspan="4">{{ $up->links() }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
