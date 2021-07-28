@extends('admin.master')

@section('title', 'Editar Usuarios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users/1') }}"><i class="fas fa-users"></i> Usuarios</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users') }}"><i class="fas fa-cogs"></i> Permisos de Usuarios: {{ $user->name }} (ID: {{ $user->id }})</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page_user">
            <form action="{{ url('/admin/user/'.$user->id.'/permissions') }}" method="POST">
                @csrf
                <div class="row">
                    @if($role->count() >= 1)
                        @include('admin.users.permissions.module_roles')
                    @endif
                    @if($permisos->count() >= 1)
                        @include('admin.users.permissions.module_permissions')
                    @endif
                    @if($usuarios->count() >= 1)
                        @include('admin.users.permissions.module_usuarios')
                    @endif
                    @if($dashboard->count() >=1)
                        @include('admin.users.permissions.module_dashboard')
                    @endif
                    @if($slider->count() >= 1)
                        @include('admin.users.permissions.module_sidebar')
                    @endif
                </div>

                <div class="row mtop16">
                    <div class="col-md-12">
                        <div class="panel shadow">
                            <div class="inside">
                                <input type="submit" value="Guardar" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
