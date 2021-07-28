<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    <title>FIPS - @yield('title')</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('static/css/style.css?v='.time()) }}">
    <script src="https://kit.fontawesome.com/b0d8aefb17.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
    <script src="{{ url('/static/js/site.js?v='.time()) }}"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('static/images/logo.png') }}"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                   <!--<li class="nav-item">
                       <a href="{{ url('/') }}" class="nav-link"><i class="fas fa-home"></i> Inicio</a>
                   </li> -->
                    @if(Auth::guest())
                        <li class="nav-item link-acc">
                            <a href="{{ url('/login') }}" class="nav-link btn"><i class="fas fa-user-circle"></i> Ingresar</a>
                        </li>
                    @else
                        <li class="nav-item link-acc link-user dropdown">
                            <a href="#" class="nav-link btn dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(is_null(auth()->user()->avatar))
                                    <img src="{{ url('/static/images/default_avatar.jpg') }}">
                                @endif
                                Hola {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown">
                                @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-dashboard'))
                                <li>
                                    <a class="dropdown-item" href="{{ url('/admin') }}">
                                        <i class="fas fa-chalkboard-teacher"></i> Administracion
                                    </a>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/account/edit') }}">
                                        <i class="fas fa-address-card"></i> Editar Perfil
                                    </a>
                                </li>
                                @if(count(auth()->user()->subjects) > 1)
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/posts') }}">
                                            <i class="fas fa-parking"></i> Publicaciones
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ url('/logout') }}">
                                        <i class="fas fa-sign-out-alt"></i> Salir
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @include('errors.error')

    <div class="wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</body>
</html>
