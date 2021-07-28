@extends('admin.master')

@section('title', 'Usuarios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users/1') }}"><i class="fas fa-users"></i>Usuarios</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-users"></i> Usuarios</h2>
                <ul>
                    @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('agregar-nuevos-usuarios'))
                        <li>
                            <a href="{{ url('/admin/user/add') }}" class="btn btn-default">
                                <i class="fas fa-plus"></i> Agregar Usuario
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('buscar-usuarios'))
                        <li>
                            <a href="#">Filtrar <i class="fas fa-chevron-down"></i></a>
                            <ul class="shadow">
                                <li><a href="{{ url('/admin/users/1') }}"><i class="fas fa-globe-americas"></i> Publicos</a></li>
                                <li><a href="{{ url('/admin/users/trash') }}"><i class="fas fa-trash"></i> Papelera</a></li>
                                <li><a href="{{ url('/admin/users/all') }}"><i class="fas fa-list"></i> Todos</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" id="btn_search">
                                <i class="fas fa-search"></i> Buscar
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="inside">
                <div class="form_search" id="form_search">
                    <form method="POST" action="{{ url('/admin/user/search') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Ingrese su busqueda">
                            </div>
                            <div class="col-md-4">
                                <select name="filter" id="filter" class="form-control">
                                    <option disabled selected>Selecciona una opción</option>
                                    <option value="0">RUT del usuario</option>
                                    <option value="1">nombre del usuario</option>
                                    <option value="2">email del usuario</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Buscar" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

                <table class="table table-bordered table-hover table-responsive-xl">
                    <caption>Cantidad de usuarios listados: {{ $users->count() }} @if($users->count() > 1 || $users->count() == 0 ) usuarios. @else usuario. @endif</caption>
                    <thead>
                        <tr>
                            <td>RUT</td>
                            <td>Nombre</td>
                            <td>Genero</td>
                            <td>Email</td>
                            <td>Telefono</td>
                            <td>Fecha de nacimiento</td>
                            <td>Tipo de usuario</td>
                            <td>Fecha de registro</td>
                            <td>Fecha de eliminación</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ Rut::parse($user->rut)->format() }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->gender->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ is_null($user->phone) ? 'Sin informacion' : $user->phone }}</td>
                                <td>{{ is_null($user->birthdate) ? 'Sin informacion' : date('d/m/Y', strtotime($user->birthdate)) }}</td>
                                <td>{{ $user->roles()->pluck('name')->implode(', ') }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>{{ is_null($user->deleted_at) ? $user->deleted_at : $user->deleted_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="opts">
                                        @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('editar-roles-de-usuarios'))
                                            @if(is_null($user->deleted_at))
                                            <a href="{{ url('/admin/user/'.$user->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif
                                        @endif
                                        @if($user->roles()->count() >= 1)
                                            @if(is_null($user->deleted_at))
                                                @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('editar-permisos-de-usuarios'))
                                                    <a href="{{ url('/admin/user/'.$user->id.'/permissions') }}" data-toggle="tooltip" data-placement="top" title="Permisos">
                                                        <i class="fas fa-cogs"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                        @if(is_null($user->deleted_at))
                                            @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('eliminar-usuarios'))
                                                <a href="#" class="btn_deleted" data-path="admin/user" data-action="delete" data-object="{{ $user->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                            <!--
                                                <a href="{{ url('/admin/user/'.$user->id.'/auditing') }}" data-toggle="tooltip" data-placement="top" title="Historial">
                                                    <i class="fas fa-history"></i>
                                                </a>
                                            -->
                                        @else
                                           <a href="{{ url('/admin/user/'.$user->id.'/restore') }}" data-action="restore" class="btn_deleted" data-path="admin/user" data-object="{{ $user->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar">
                                                <i class="fas fa-trash-restore"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="10">{{ $users->links() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
