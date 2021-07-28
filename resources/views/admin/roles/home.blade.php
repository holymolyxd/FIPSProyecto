@extends('admin.master')

@section('title', 'Roles')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/roles/1') }}"><i class="fas fa-user-tag"></i>Roles</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-user-tag"></i> Roles</h2>
                <ul>
                    @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('agregar-nuevos-roles'))
                    <li>
                        <a href="{{ url('/admin/role/add') }}" class="btn btn-default">
                            <i class="fas fa-plus"></i> Agregar Rol
                        </a>
                    </li>
                    @endif
                    @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('buscar-roles'))
                    <li>
                        <a href="#">Filtrar <i class="fas fa-chevron-down"></i></a>
                        <ul class="shadow">
                            <li><a href="{{ url('/admin/roles/1') }}"><i class="fas fa-globe-americas"></i> Publicos</a></li>
                            <li><a href="{{ url('/admin/roles/trash') }}"><i class="fas fa-trash"></i> Papelera</a></li>
                            <li><a href="{{ url('/admin/roles/all') }}"><i class="fas fa-list"></i> Todos</a></li>
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
                    <form method="POST" action="{{ url('/admin/role/search') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Ingrese su busqueda">
                            </div>
                            <div class="col-md-4">
                                <select name="filter" id="filter" class="form-control">
                                    <option disabled selected>Selecciona una opción</option>
                                    <option value="0">Nombre del rol</option>
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
                    <caption>Cantidad de roles listados: {{ $roles->count() }} @if($roles->count() > 1 || $roles->count() == 0 ) roles. @else rol. @endif</caption>
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Nombre</td>
                        <td>Slug</td>
                        <td>Descipción</td>
                        <td>Fecha de creación</td>
                        <!--<td>Fecha de modificación</td>-->
                        <td>Fecha de eliminación</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->slug }}</td>
                                <td>{{ $role->description }}</td>
                                <td>{{ $role->created_at->format('d/m/Y') }}</td>
                                <!--<td>{{ $role->updated_at->format('d/m/Y') }}</td>-->
                                @if(is_null($role->deleted_at))
                                    <td>{{ $role->deleted_at }}</td>
                                @else
                                    <td>{{ $role->deleted_at->format('d/m/Y') }}</td>
                                @endif
                                <td>
                                    <div class="opts">
                                        @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('editar-roles'))
                                            @if(is_null($role->deleted_at))
                                            <a href="{{ url('/admin/role/'.$role->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif
                                        @endif

                                    @if(is_null($role->deleted_at))
                                        @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('eliminar-roles'))
                                            <a href="#" class="btn_deleted" data-path="admin/role" data-action="delete" data-object="{{ $role->id }}" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                            @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('historial-de-roles'))
                                                <a href="{{ url('/admin/role/'.$role->id.'/auditing') }}" data-toggle="tooltip" data-placement="top" title="Historial">
                                                    <i class="fas fa-history"></i>
                                                </a>
                                            @endif
                                    @else
                                        @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('restaurar-roles'))
                                            <a href="{{ url('/admin/role/'.$role->id.'/restore') }}" data-action="restore" class="btn_deleted" data-path="admin/role" data-object="{{ $role->id }}" data-toggle="tooltip" data-placement="top" title="Restaurar">
                                                <i class="fas fa-trash-restore"></i>
                                            </a>
                                        @endif
                                    @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="8">{{ $roles->links() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
