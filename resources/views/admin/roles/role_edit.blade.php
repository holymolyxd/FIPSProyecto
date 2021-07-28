@extends('admin.master')

@section('title', 'Editar Roles')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/roles/1') }}"><i class="fas fa-user-tag"></i>Roles</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/role/'.$r->id.'/edit') }}"><i class="fas fa-tag"></i> Rol: {{ $r->name }} (ID: {{ $r->id }})</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page_user">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-user-tag"></i> Información del Rol</h2>
                        </div>

                        <div class="inside">
                            <div class="mini_profile">
                                <div class="info">
                                    <span class="title"><i class="fab fa-slack-hash"></i> ID:</span>
                                    <span class="text">{{ $r->id }}</span>
                                    <span class="title"><i class="far fa-address-card"></i> Nombre del rol:</span>
                                    <span class="text">{{ $r->name }}</span>
                                    <span class="title"><i class="fas fa-link"></i> Slug:</span>
                                    <span class="text">{{ $r->slug }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Descripción:</span>
                                    <span class="text">{{ $r->description }}</span>
                                    <span class="title"><i class="far fa-calendar-alt"></i> Fecha de registro:</span>
                                    <span class="text">{{ $r->created_at->format('d/m/Y') }} {{ $r->created_at->diffForHumans() }}</span>
                                    <span class="title"><i class="far fa-calendar-alt"></i> Fecha de modificacion:</span>
                                    <span class="text">{{ $r->updated_at->format('d/m/Y') }} {{ $r->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-edit"></i> Editar Rol</h2>
                        </div>

                        <div class="inside">
                            <form method="POST" action="{{ url('/admin/role/'.$r->id.'/edit') }}">
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
                                            <input type="text" name="name" id="name" maxlength="15" class="form-control" value="{{ $r->name }}" disabled>
                                        </div>
                                        <div id="contador2"></div>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="description">Descripción:</label>
                                        <textarea name="description" id="description" rows="3" maxlength="50" class="form-control" style="height: 40px;">{{ $r->description }}</textarea>
                                        <div id="contador"></div>
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
                    <div class="panel shadow mtop16">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-address-card"></i> Permisos del Rol</h2>
                        </div>
                        <div class="inside">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <caption>Cantidad de permisos listados: {{ $rp->count() }} @if($rp->count() > 1 || $rp->count() == 0 ) permisos. @else permiso. @endif</caption>
                                        <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>Nombre</td>
                                            <td>Fecha de creación</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rp as $permission)
                                                <tr>
                                                    <td>{{ $permission->id }}</td>
                                                    <td>{{ $permission->name }}</td>
                                                    <td>{{ $permission->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                            <td colspan="3">{{ $rp->links() }}</td>
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
