@extends('admin.master')

@section('title', 'Agregar Permisos')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/permissions') }}"><i class="fas fa-user-tag"></i> Permisos</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/permission/add') }}"><i class="fas fa-plus"></i> Agregar Permiso</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-plus"></i> Agregar Permiso</h2>
            </div>

            <div class="inside">
                <form method="POST" action="{{ url('/admin/permission/add') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label for="name">Nombre del Permiso:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                <input type="text" name="name" id="name" maxlength="25" class="form-control" value="{{ old('name') }}">
                            </div>
                            <div id="contador2"></div>
                        </div>
                        <div class="col-md-5">
                            <label for="description">Descripción:</label>
                            <textarea name="description" id="description" rows="3" maxlength="55" class="form-control" style="height: 40px;">{{ old('description') }}</textarea>
                            <div id="contador"></div>
                        </div>

                        <div class="col-md-4">
                            <label for="module">Modulo:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                <select name="module" id="module" class="selectpicker form-control" title="Selecciona una opción" data-size="8">
                                    <option value="dashboard">Dashboard</option>
                                    <option value="usuarios">Usuarios</option>
                                    <option value="roles">Roles</option>
                                    <option value="permisos">Permisos</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mtop16">
                        <div class="col-md-12">
                            <input type="submit" value="Guardar" class="btn btn-success">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
