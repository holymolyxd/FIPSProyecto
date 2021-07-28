@extends('master')

@section('title', 'Inicio')

@section('content')
<section>
    <div class="home_action_bar">
        <div class="row">
            <div class="col-md-12">
                <form action="#">
                    <div class="input-group mb-2">
                        <div class="input-group">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search_query" class="form-control" placeholder="¿Buscas algo?" required>
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Button</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid mtop16">
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
                            <div class="text-muted small mt-1">{{ date_format($post->created_at,'d/m/Y') }} &nbsp;·&nbsp; {{ $post->user->email }} <a href="javascript:void(0)" class="text-muted" data-abc="true" style="text-decoration: none; cursor:auto;"></a></div>
                            <div class="text-muted small mt-1">{{ $post->user->career->name }} &nbsp;·&nbsp; <a href="javascript:void(0)" class="text-muted" data-abc="true" style="text-decoration: none; cursor:auto;">{{ $post->subject->name }}</a></div>
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
        </div>
    @endforeach
    {{ $posts->links() }}
</div>
@endsection
