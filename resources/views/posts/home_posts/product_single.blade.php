@extends('master')

@section('title',$post->title)

@section('content')
    <div class="post_single shadow-lg">
        <div class="inside">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 pleft0">

                    </div>
                    <div class="col-md-8">
                        <h2 class="title">{{ $post->title }}</h2>
                        <h5>
                            @if($post->status == 0)
                                <span class="badge badge-primary">Publico</span>
                            @else
                                <span class="badge badge-danger">Finalizado</span>
                            @endif
                        </h5>
                        <div class="category">
                            <ul>
                                <li><a href="{{ url('/') }}"><i class="fas fa-house-user"></i> Inicio</a></li>
                                <li><span class="next"><i class="fas fa-chevron-right"></i></span></li>
                                <li><a href="{{ url('/user/'.$post->user->id.'/'.$post->user->email.'/posts') }}"><i class="fas fa-user"></i> {{ $post->user->email }}</a></li>
                                <li><span class="next"><i class="fas fa-chevron-right"></i></span></li>
                                <li><a href="{{ url('/careers/'.$post->user->career->id.'/'.$post->user->career->slug.'/posts') }}"><i class="fas fa-graduation-cap"></i> {{ $post->user->career->name }}</a></li>
                                <li><span class="next"><i class="fas fa-chevron-right"></i></span></li>
                                <li><a href="{{ url('/subjects/'.$post->subject->id.'/'.$post->subject->slug.'/posts') }}"><i class="fas fa-book"></i> {{ $post->subject->name }}</a></li>
                            </ul>
                        </div>
                        <div class="content">
                            {{ $post->details }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center mtop16">
        <div class="col-md-8">
            <div class="headings d-flex justify-content-between align-items-center mb-3">
                @if(count($post->comments) >= 1)
                    <h5>Listado de comentarios</h5>
                @else
                    <h5>No existen comentarios</h5>
                @endif
            </div>
            @foreach($post->comments as $comment)
                <div class="card p-3 mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="user d-flex flex-row align-items-center"> <img src="{{ $comment->user->avatar }}" width="30" class="user-img rounded-circle mr-2"> <span><small class="font-weight-bold text-danger">{{ $comment->user->email }}</small> <small class="font-weight-bold">{{ $comment->content }}</small></span> </div> <small>{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="action d-flex justify-content-between mt-2 align-items-center">
                        <div class="reply px-4">
                            <small>Remove</small>
                            <span class="dots"></span>
                            <small>Reply</small>
                            <span class="dots"></span>
                            <small>Translate</small>
                        </div>
                        <div class="icons align-items-center">
                            @if($post->status == 0)
                                @if(auth()->id() == $post->user_id)
                                    <form action="{{ url('/post/'.$post->id.'/'.$post->slug.'/'.$comment->id.'/finish') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary fa fa-check-circle-o check-icon"></button>
                                    </form>
                                @endif
                            @else
                                @if($comment->status == 0)
                                    <i class="fa fa-check-circle-o check-icon"></i>
                                @else
                                    <i class="fa fa-check-circle-o check-icon text-primary"></i>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if(auth()->user()->hasRole("estudiante"))
        @if(auth()->user()->semester->id >= $post->user->semester->id)
            @if($post->status == 0)
            <div class="container">
                <div class="answers_posts mtop32 shadow">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="title">Agregar un comentario</h5>
                                <form action="{{ url('/post/'.$post->id.'/'.$post->slug.'/comments') }}" method="POST">
                                    @csrf
                                    <textarea name="answer" id="answer" class="form-control" cols="10" rows="2"></textarea>
                                    <input type="submit" value="Agregar comentario" class="btn btn-success mtop16">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @else
            <div class="container mtop16">
                <span class="title text-danger"><strong>Nota:</strong> Al ir en un semestre menor al usuario de la publicacion, solo pueder ver su contenido y respuestas</span>
            </div>
        @endif
    @endif
@endsection
