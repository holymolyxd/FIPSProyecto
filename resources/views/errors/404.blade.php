@extends('connect.master')

@section('title','Pagina no encontrada')
@section('content')
    <section style="padding-top: 250px;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <h1 style="font-size: 162px; color: rgb(208, 0, 0)"><strong>404</strong></h1>
                    <h2>Página no encontrada</h2>
                    <p class="display-5">Se trabajara para poder implementarla.</p>
                    <p class="display-5">Favor vuelve al inicio.</p>
                    <a href="{{ url('/') }}" style="text-decoration: none !important; color: rgb(208, 0, 0)">Página de inicio</a>
                </div>
            </div>
        </div>
    </section>
@endsection
