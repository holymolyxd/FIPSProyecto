@extends('master')

@section('title', 'Publicaciones')

@section('content')
    <div class="row mtop32">
        <div class="col-md-12">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fas fa-parking"></i> Mis Publicaciones</h2>
                    <ul>
                        <li>
                            <a href="{{ url('/post/add') }}" class="btn btn-default">
                                <i class="fas fa-plus"></i> Crear publicación
                            </a>
                        </li>
                        <!--<li>
                            <a href="#">Filtrar <i class="fas fa-chevron-down"></i></a>
                            <ul class="shadows">
                                <li><a href="#"><i class="fas fa-globe-americas"></i> Publicos</a></li>
                                <li><a href="#"><i class="fas fa-eye-slash"></i> No publicados</a></li>
                            </ul>
                        </li>-->
                        <li>
                            <a href="#" id="btn_search">
                                <i class="fas fa-search"></i> Buscar
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="inside">
                    <div class="form_search" id="form_search">
                        <form method="POST" action="{{ url('/post/search') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="search" class="form-control" placeholder="Ingrese su busqueda">
                                </div>
                                <div class="col-md-4">
                                    <select name="filter" id="filter" class="form-control">
                                        <option disabled selected>Selecciona una opción</option>
                                        <option value="0">Titulo</option>
                                        <option value="1">Contenido</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <input type="submit" value="Buscar" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>

                    <table class="table table-bordered table-hover">
                        <caption>Cantidad de publicaciones listadas: {{ $posts->count() }} @if($posts->count() > 1 || $posts->count() == 0 ) publicaciones. @else publicacion. @endif</caption>
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Titulo</td>
                            <td>Contenido</td>
                            <td>Asignatura</td>
                            <td>Fecha de creacion</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($posts) == 0)
                            <tr>
                                <td colspan="6" style="text-align: center;">No existen publicaciones</td>
                            </tr>
                        @else
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->details }}</td>
                                    <td>{{ $post->subject->name }}</td>
                                    <td>{{ is_null($post->created_at) ? $post->created_at : $post->created_at->format('d/m/Y')  }}</td>
                                    <td>
                                        <div class="opts">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
