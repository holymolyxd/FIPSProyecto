@extends('master')

@section('title', 'Publicaciones de: '. $subject->name)

@section('content')
    <div class="container-fluid mtop16">
        <div class="panel shadow mtop16">
            <div class="inside">
                <form method="POST" action="{{ url('/subjects/'.$subject->id.'/'.$subject->slug.'/posts/search') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control" placeholder="Ingrese su busqueda">
                        </div>
                        <div class="col-md-5">
                            <select name="filter" id="filter" class="form-control">
                                <option disabled selected>Selecciona una opción</option>
                                <option value="0">Titulo</option>
                                <option value="1">Contenido</option>
                                <option value="2">Carrera</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="submit" value="Buscar" class="btn btn-primary" style="width: 100%; background-color: rgb(208, 0, 0); border: 1px solid rgb(208, 0, 0)">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="page-user mtop16">
            <div class="row">
                <div class="col-md-5">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-user-edit"></i> Información de la asignatura</h2>
                        </div>

                        <div class="inside">
                            <div class="mini_profile">
                                <div class="info">
                                    <span class="title"><i class="far fa-address-card"></i> Nombre asignatura:</span>
                                    <strong><span class="text">{{ $subject->name }}</span></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-user-edit"></i> Carreras</h2>
                        </div>
                        <div class="inside">
                            <div class="mini_profile">
                                <div class="venues_subjects">
                                    <span class="title"><i class="fas fa-graduation-cap"></i> Asignatura impartida en:</span>
                                    <strong><span class="text">@if(count($subject->careers) > 1) {{ count($subject->careers) }} carreras @else {{ count($subject->careers) }} carrera  @endif</span></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-user-edit"></i> Usuarios</h2>
                        </div>
                        <div class="inside">
                            <div class="mini_profile">
                                <div class="user_count_post">
                                    <span class="title"><i class="fas fa-pencil-alt"></i> Usuarios registrados:</span>
                                    <strong><span class="text"></span></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-user-edit"></i> Publicaciones</h2>
                        </div>
                        <div class="inside">
                            <div class="mini_profile">
                                <div class="user_count_post">
                                    <span class="title"><i class="fas fa-pencil-alt"></i> Publicaciones listadas:</span>
                                    <strong><span class="text">{{ count($subject->posts) }}</span></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mtop16">Publicaciones de la asignatura</h4>
        @foreach($posts as $post)
            <div class="posts">
                <div class="card mb-3 shadow" style="margin-top: 10px">
                    <div class="card-header pl-0 pr-0">
                        <div class="row no-gutters w-100 align-items-center">
                            <div class="col ml-3">{{ $post->title }}</div>
                            <div class="col-4 text-muted">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-4 offset-2">Comentarios</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="card-body py-3">
                        <div class="row no-gutters align-items-center">
                            <div class="col"> <a href="{{ url('/post/'.$post->id.'/'.$post->slug) }}" style="color: rgb(208, 0, 0); text-decoration: none" class="text-big" data-abc="true">{{ substr($post->details,0,50) }}...</a>
                                <div class="text-muted small mt-1">{{ date_format($post->created_at,'d/m/Y') }} &nbsp;·&nbsp; <a href="javascript:void(0)" class="text-muted" data-abc="true" style="text-decoration: none; cursor:auto;">{{ $post->email }}</a></div>
                                <div class="text-muted small mt-1">{{ $post->career_name }} &nbsp;·&nbsp; <a href="javascript:void(0)" class="text-muted" data-abc="true" style="text-decoration: none; cursor:auto;">{{ $post->subject_name }}</a></div>
                            </div>
                            <div class="d-none d-md-block col-2">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-12"><a href="javascript:void(0)" class="text-muted" data-abc="true" style="text-decoration: none;">{{ count($post->comments) }}</a></div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                @if($post->status == 0)
                                    <span class="badge badge-primary">Publico</span>
                                @else
                                    <span class="badge badge-danger">Finalizado</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{ $posts->links() }}
            </div>
    </div>
@endsection
