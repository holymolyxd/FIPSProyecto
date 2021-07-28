@extends('admin.master')

@section('title', 'Editar Publicacion')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/posts') }}"><i class="fab fa-product-hunt"></i> Publicaciones</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/post/'.$p->id.'/edit') }}"><i class="fas fa-address-card"></i> Publicacion: {{ $p->name }} (ID: {{ $p->id }})</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page_user">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-address-card"></i> Información de la Publicacion</h2>
                        </div>

                        <div class="inside">
                            <div class="mini_profile">
                                <div class="info">
                                    <span class="title"><i class="fab fa-slack-hash"></i> ID:</span>
                                    <span class="text">{{ $p->id }}</span>
                                    <span class="title"><i class="far fa-address-card"></i> Titulo de la publicacion:</span>
                                    <span class="text">{{ $p->title }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Contenido:</span>
                                    <span class="text">{{ $p->details }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Carrera:</span>
                                    <span class="text">{{ $p->user->career->name }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Semestre:</span>
                                    <span class="text">{{ $p->user->semester->name }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Asignatura:</span>
                                    <span class="text">{{ $p->subject->name }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Autor:</span>
                                    <span class="text">{{ $p->user->email }}</span>
                                    <span class="title"><i class="far fa-calendar-alt"></i> Fecha de registro:</span>
                                    <span class="text">{{ $p->created_at->format('d/m/Y') }} {{ $p->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-edit"></i> Editar Publicacion</h2>
                        </div>

                        <div class="inside">
                            <form method="POST" action="{{ url('/admin/post/'.$p->id.'/edit') }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="title">Titulo de la publicacion:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="fas fa-keyboard"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="title" id="title" maxlength="20" class="form-control" value="{{ $p->title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="details">Contenido de la publicacion:</label>
                                        <textarea name="details" id="details" rows="3" maxlength="50" class="form-control" style="height: 40px;">{{ $p->details }}</textarea>
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
