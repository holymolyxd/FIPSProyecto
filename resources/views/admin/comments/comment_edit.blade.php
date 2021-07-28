@extends('admin.master')

@section('title', 'Editar Comentario')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/comments') }}"><i class="fas fa-comments"></i> Comentarios</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/comment/'.$c->id.'/edit') }}"><i class="fas fa-address-card"></i> Comentario: {{ $c->name }} (ID: {{ $c->id }})</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page_user">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-address-card"></i> Información del Comentario</h2>
                        </div>

                        <div class="inside">
                            <div class="mini_profile">
                                <div class="info">
                                    <span class="title"><i class="fab fa-slack-hash"></i> ID:</span>
                                    <span class="text">{{ $c->id }}</span>
                                    <span class="title"><i class="far fa-address-card"></i> Titulo de la publicacion:</span>
                                    <span class="text">{{ $c->post->title }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Contenido:</span>
                                    <span class="text">{{ $c->post->details }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Carrera:</span>
                                    <span class="text">{{ $c->user->career->name }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Semestre:</span>
                                    <span class="text">{{ $c->user->semester->name }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Asignatura:</span>
                                    <span class="text">{{ $c->post->subject->name }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Autor de la publicacion:</span>
                                    <span class="text">{{ $c->post->user->email }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Autor del comentario:</span>
                                    <span class="text">{{ $c->user->email }}</span>
                                    <span class="title"><i class="far fa-file-alt"></i> Comentario:</span>
                                    <span class="text">{{ $c->content }}</span>
                                    <span class="title"><i class="far fa-calendar-alt"></i> Fecha de registro:</span>
                                    <span class="text">{{ $c->created_at->format('d/m/Y') }} {{ $c->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-edit"></i> Editar Comentario</h2>
                        </div>

                        <div class="inside">
                            <form method="POST" action="{{ url('/admin/comment/'.$c->id.'/edit') }}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-7">
                                        <label for="content">Contenido del comentario:</label>
                                        <textarea name="content" id="content" rows="3" maxlength="50" class="form-control" style="height: 40px;">{{ $c->content }}</textarea>
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
