@extends('admin.master')

@section('title', 'Comentarios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/comments') }}"><i class="fas fa-comments"></i> Comentarios</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-comments"></i> Comentarios</h2>
                <ul>
                    <li>
                        <a href="#" id="btn_search">
                            <i class="fas fa-search"></i> Buscar
                        </a>
                    </li>
                </ul>
            </div>

            <div class="inside">
                <div class="form_search" id="form_search">
                    <form method="POST" action="{{ url('/admin/comment/search') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Ingrese su busqueda">
                            </div>
                            <div class="col-md-4">
                                <select name="filter" id="filter" class="form-control">
                                    <option disabled selected>Selecciona una opción</option>
                                    <option value="0">Titulo</option>
                                    <option value="1">Contenido</option>
                                    <option value="2">Asignatura</option>
                                    <option value="3">Carrera</option>
                                    <option value="4">Semestre</option>
                                    <option value="5">Dueño del comentario</option>
                                    <option value="6">Contenido del comentario</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Buscar" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

                <table class="table table-bordered table-hover table-responsive-xl">
                    <caption>Cantidad de comentarios listados: {{ $users_comments->count() }} @if($users_comments->count() > 1 || $users_comments->count() == 0 ) comentarios. @else comentario. @endif</caption>
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Titulo</td>
                        <td>Contenido</td>
                        <td>Carrera</td>
                        <td>Semestre</td>
                        <td>Asignatura</td>
                        <td>Dueño del comentario</td>
                        <td>Contenido del comentario</td>
                        <td>Fecha de creacion</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users_comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->title }}</td>
                            <td>{{ $comment->details }}...</td>
                            <td>{{ $comment->career_name }}</td>
                            <td>{{ $comment->semester_name }}</td>
                            <td>{{ $comment->subject_name }}</td>
                            <td>{{ $comment->email }}</td>
                            <td>{{ $comment->content }}</td>
                            <td>{{ $comment->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="opts">
                                    <a href="{{ url('/admin/comment/'.$comment->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ url('/admin/comment/'.$comment->id.'/auditing') }}" data-toggle="tooltip" data-placement="top" title="Historial">
                                        <i class="fas fa-history"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tr>
                        <td colspan="11">{{ $users_comments->links() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
