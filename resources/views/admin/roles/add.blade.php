@extends('admin.master')

@section('title', 'Agregar Roles')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/roles/1') }}"><i class="fas fa-user-tag"></i> Roles</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/role/add') }}"><i class="fas fa-plus"></i> Agregar Rol</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-plus"></i> Agregar Rol</h2>
            </div>

            <div class="inside">
                <form method="POST" action="{{ url('/admin/role/add') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Nombre del Rol:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                <input type="text" name="name" id="name" maxlength="20" class="form-control" value="{{ old('name') }}">
                            </div>
                            <div id="contador2"></div>
                        </div>
                        <div class="col-md-8">
                            <label for="description">Descripción:</label>
                            <textarea name="description" id="description" rows="3" maxlength="60" class="form-control" style="height: 40px;">{{ old('description') }}</textarea>
                            <div id="contador"></div>
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
