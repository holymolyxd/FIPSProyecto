@extends('admin.master')

@section('title', 'Permisos')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/permissions/1') }}"><i class="fas fa-address-card"></i> Permisos</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-address-card"></i> Permisos</h2>
                <ul>
                    @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('agregar-nuevos-permisos'))
                        <li>
                            <a href="{{ url('/admin/permission/add') }}" class="btn btn-default">
                                <i class="fas fa-plus"></i> Agregar Permiso
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('buscar-permisos'))
                        <li>
                            <a href="#">Filtrar <i class="fas fa-chevron-down"></i></a>
                            <ul class="shadow">
                                <li><a href="{{ url('/admin/permissions/1') }}"><i class="fas fa-globe-americas"></i> Publicos</a></li>
                                <li><a href="{{ url('/admin/permissions/trash') }}"><i class="fas fa-trash"></i> Papelera</a></li>
                                <li><a href="{{ url('/admin/permissions/all') }}"><i class="fas fa-list"></i> Todos</a></li>
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
                    <form method="POST" action="{{ url('/admin/permission/search') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Ingrese su busqueda">
                            </div>
                            <div class="col-md-4">
                                <select name="filter" id="filter" class="form-control">
                                    <option disabled selected>Selecciona una opción</option>
                                    <option value="0">Nombre del Permiso</option>
                                    <option value="1">Descripción</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Buscar" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

                <table class="table table-bordered table-hover table-responsive-xl">
                <caption>Cantidad de permisos listados: {{ $permissions->count() }} @if($permissions->count() > 1 || $permissions->count() == 0 ) permisos. @else permiso. @endif</caption>
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Nombre</td>
                        <td>Slug</td>
                        <td>Descripcion</td>
                        <td>Rol con Permiso</td>
                        <td>Fecha de creación</td>
                        <!--<td>Fecha de modificación</td>-->
                        <td>Fecha de eliminación</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->slug }}</td>
                                <td>{{ $permission->description }}</td>
                                <td>{{ $permission->roles()->pluck('name')->implode(', ') }}</td>
                                <td>{{ $permission->created_at->format('d/m/Y') }}</td>
                                <!--<td>{{ $permission->updated_at->format('d/m/Y') }}</td>-->
                                @if(is_null($permission->deleted_at))
                                    <td>{{ $permission->deleted_at }}</td>
                                @else
                                    <td>{{ $permission->deleted_at->format('d/m/Y') }}</td>
                                @endif
                                <td>
                                    <div class="opts">
                                        @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('editar-permisos'))
                                            @if(is_null($permission->deleted_at))
                                                <a href="{{ url('/admin/permission/'.$permission->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        @endif
                                        @if(is_null($permission->deleted_at))
                                            @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('eliminar-permisos'))
                                                    <a href="#" class="btn_deleted" data-path="admin/permission" data-action="delete" data-object="{{ $permission->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                            @endif
                                            @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('historial-de-permisos'))
                                                <a href="{{ url('/admin/permission/'.$permission->id.'/auditing') }}" data-toggle="tooltip" data-placement="top" title="Historial">
                                                    <i class="fas fa-history"></i>
                                                </a>
                                            @endif
                                        @else
                                            @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('restaurar-permisos'))
                                                <a href="{{ url('/admin/permission/'.$permission->id.'/restore') }}" data-action="restore" class="btn_deleted" data-path="admin/permission" data-object="{{ $permission->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar">
                                                    <i class="fas fa-trash-restore"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tr>
                        <td colspan="9">{{ $permissions->links() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
