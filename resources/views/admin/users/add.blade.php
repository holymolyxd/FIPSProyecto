@extends('admin.master')

@section('title', 'Agregar Usuarios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/users/1') }}"><i class="fas fa-users"></i> Usuarios</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/user/add') }}"><i class="fas fa-plus"></i> Agregar Usuario</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-plus"></i> Agregar Usuario</h2>
            </div>

            <div class="inside">
                <form method="POST" action="{{ url('/admin/user/add') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-2">
                            <label for="rut">Rut del usuario:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                <input type="text" name="rut" id="rut" maxlength="9" class="form-control" value="{{ old('rut') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="username">Nombre de usuario:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                <input type="text" name="username" id="username" maxlength="20" class="form-control" value="{{ old('username') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="email">Correo electronico:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" id="email" maxlength="40" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="password">Contraseña:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                <input type="text" name="password" id="password" maxlength="8" class="form-control" value="{{ old('password') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="cpassword">Confirmar Contraseña:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                </div>
                                <input type="text" name="cpassword" id="cpassword" maxlength="8" class="form-control" value="{{ old('cpassword') }}">
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
