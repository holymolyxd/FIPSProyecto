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
    <link rel="stylesheet" href="{{ url('static/css/admin.css?v='.time()) }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b0d8aefb17.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ url('/static/js/admin.js?v='.time()) }}"></script>
</head>
<body>
    <div class="wrapper d-flex" id="wrapper">
        <div class="col1">@include('admin.sidebar')</div>
        <div class="col2">
            <nav class="navbar navbar-expand-lg shadow">
                <button class="btn" id="menu-toggle">
                    <i class="fas fa-align-left" style="color: #FFFFFF !important;"></i>
                </button>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-list" style="color: #FFFFFF !important;"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-dashboard') || auth()->user()->hasRole("coordinador") && auth()->user()->hasPermission('ver-dashboard'))
                            <li class="nav-item">
                                <a href="{{ url('/admin') }}" class="nav-link"><i class="fas fa-home"></i> Dashboard</a>
                            </li>
                        @endif
                <!--@if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-slider') || auth()->user()->hasRole("coordinador") && auth()->user()->hasPermission('ver-slider'))
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-paste"></i> Sidebar</a>
                    </li>
                @endif-->
                @if(auth()->user()->hasRole("administrador"))
                    @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-listado-de-roles'))
                        <li class="nav-item">
                            <a href="{{ url('/admin/roles/1') }}" class="nav-link"><i class="fas fa-user-tag"></i> Roles</a>
                        </li>
                    @endif
                    @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-listado-de-permisos'))
                        <li class="nav-item">
                            <a href="{{ url('/admin/permissions/1') }}" class="nav-link"><i class="fas fa-address-card"></i> Permisos</a>
                        </li>
                    @endif
                    @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-listado-de-usuarios'))
                    <li class="nav-item">
                        <a href="{{ url('/admin/users/1') }}" class="nav-link"><i class="fas fa-users"></i> Usuarios</a>
                    </li>
                    @endif
                    <!--
                        <li class="nav-item">
                            <a href="{{ url('/admin/regions') }}" class="nav-link"><i class="far fa-bookmark"></i> Regiones</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/communes') }}" class="nav-link"><i class="fas fa-location-arrow"></i> Comunas</a>
                        </li>
                        -->
                @endif
                        <li class="nav-item">
                            <a href="{{ url('/admin/posts') }}" class="nav-link"><i class="fab fa-product-hunt"></i> Publicaciones</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/admin/comments') }}" class="nav-link"><i class="fas fa-comments"></i> Comentarios</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="page">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb shadow">
                        <ol class="breadcrumb">
                            @if(auth()->user()->hasRole("administrador") && auth()->user()->hasPermission('ver-dashboard') || auth()->user()->hasRole("coordinador") && auth()->user()->hasPermission('ver-dashboard'))
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/admin') }}"><i class="fas fa-home"></i> Dashboard</a>
                                </li>
                            @endif
                            @section('breadcrumb')
                            @show
                        </ol>
                    </nav>
                </div>
                @include('errors.error')

                @section('content')
                @show
            </div>
        </div>
    </div>
</body>
</html>
