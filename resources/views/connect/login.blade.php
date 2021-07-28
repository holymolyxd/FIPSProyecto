@extends('connect.master')

@section('title','Login')

@section('content')
    <div class="box box_login shadow">
        <div class="header">
            <a href="{{ url('/') }}">
                <img src="{{ url('/static/images/logoINACAP.png') }}" alt="Logo">
            </a>
        </div>
        <div class="inside">
            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <label for="email">Correo electrónico:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="far fa-envelope-open"></i></div>
                    </div>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>

                <label for="password" class="mtop16">Contraseña:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                    </div>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mtop16">
                    <input type="submit" value="Iniciar sesión" class="btn btn-success">
                </div>
            </form>

            <div class="mtop16">
                <a href="{{ url('/authorize') }}" class="btn btn-success" style="background-color: #718096">Login AD</a>
            </div>

            @include('errors.error')

            <div class="footer mtop16">
            <!-- <a href="{{ url('/register') }}">¿No tienes una cuenta?, Registrate</a> -->
                <p>Recuperar clave. Click </p><a href="{{ url('/recover') }}"> aquí</a><p>.</p>
            </div>
        </div>
    </div>
@stop
