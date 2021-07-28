@extends('admin.master')

@section('title', 'Editar Permisos')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/permissions/1') }}"><i class="fas fa-address-card"></i> Permisos</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/permission/'.$p->id.'/edit') }}"><i class="fas fa-address-card"></i> Permiso: {{ $p->name }} (ID: {{ $p->id }})</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page_user">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-address-card"></i> Información del Permiso</h2>
                        </div>

                        <div class="inside">
                            <div class="mini_profile">
                                <div class="info">
                                    <span class="title"><i class="fab fa-slack-hash"></i> ID:</span>
                                    <span class="text">{{ $p->id }}</span>
                                    <span class="title"><i class="far fa-address-card"></i> Nombre del rol:</span>
                                    <span class="text">{{ $p->name }}</span>
                                    <span class="title"><i class="fas fa-link"></i> Slug:</span>
                                    <span class="text">{{ $p->slug }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Descripción:</span>
                                    <span class="text">{{ $p->description }}</span>
                                    <span class="title"><i class="far fa-calendar-alt"></i> Fecha de registro:</span>
                                    <span class="text">{{ $p->created_at->format('d/m/Y') }} {{ $p->created_at->diffForHumans() }}</span>
                                    <span class="title"><i class="far fa-calendar-alt"></i> Fecha de modificacion:</span>
                                    <span class="text">{{ $p->updated_at->format('d/m/Y') }} {{ $p->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-edit"></i> Editar Permiso</h2>
                        </div>

                        <div class="inside">
                            <form method="POST" action="{{ url('/admin/permission/'.$p->id.'/edit') }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="name">Nombre del rol:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-keyboard"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="name" id="name" maxlength="20" class="form-control" value="{{ $p->name }}" disabled>
                                        </div>
                                        <div id="contador2"></div>

                                    </div>
                                    <div class="col-md-7">
                                        <label for="description">Descripción:</label>
                                        <textarea name="description" id="description" rows="3" maxlength="50" class="form-control" style="height: 40px;">{{ $p->description }}</textarea>
                                        <div id="contador"></div>
                                    </div>

                                    <div class="col-md-6 mtop16">
                                        <label for="rol">Rol:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-keyboard"></i>
                                                </span>
                                            </div>
                                            <select name="rol[]" multiple id="rol" class="selectpicker form-control" title="Selecciona una opción" data-size="4">
                                                @foreach($r as $role)
                                                    <option value="{{$role->id}}" {{$p->permissionHasRole($role->name) ? 'selected' : ''}}>{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mtop16">
                                    <div class="col-md-12">
                                        <input type="submit" value="Editar" class="btn btn-success">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
