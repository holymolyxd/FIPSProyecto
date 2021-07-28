@extends('admin.master')

@section('title', 'Publicaciones')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/posts') }}"><i class="fab fa-product-hunt"></i> Publicaciones</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fab fa-product-hunt"></i> Publicaciones</h2>
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
                    <form method="POST" action="{{ url('/admin/post/search') }}">
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
                                    <option value="5">Dueño de la publicacion</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Buscar" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

                <table class="table table-bordered table-hover table-responsive-xl">
                    <caption>Cantidad de publicaciones listadas: {{ $users_posts->count() }} @if($users_posts->count() > 1 || $users_posts->count() == 0 ) publicaciones. @else publicacion. @endif</caption>
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Titulo</td>
                        <td>Contenido</td>
                        <td>Carrera</td>
                        <td>Semestre</td>
                        <td>Asignatura</td>
                        <td>Dueño de la publicacion</td>
                        <td>Fecha de creacion</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users_posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->details }}</td>
                            <td>{{ $post->career_name }}</td>
                            <td>{{ $post->semester_name }}</td>
                            <td>{{ $post->subject_name }}</td>
                            <td>{{ $post->email }}</td>
                            <td>{{ $post->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="opts">
                                    <a href="{{ url('/admin/post/'.$post->id.'/auditing') }}" data-toggle="tooltip" data-placement="top" title="Historial">
                                        <i class="fas fa-history"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
