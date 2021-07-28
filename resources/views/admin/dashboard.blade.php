@extends('admin.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-home"></i> Estadisticas rapidas</h2>
            </div>
        </div>
    @if(auth()->user()->hasPermission('ver-estadisticas-rapidas'))
        <div class="row mtop16">

                <div class="col-md-2">
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fas fa-users"></i> Usuarios registrados</h2>
                        </div>
                        <div class="inside">
                            <div class="big_count">{{ $users }}</div>
                            <hr>
                            <button class="btn btn-danger" style="width: 100%">
                                <a href="{{ url('/admin/reportUsers') }}" style="color:white; text-decoration: none;">Descargar Reporte</a>
                            </button>
                        </div>
                    </div>
                </div>

            <div class="col-md-2">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-users"></i> Roles registrados</h2>
                    </div>
                    <div class="inside">
                        <div class="big_count">{{ $roles }}</div>
                        <hr>
                        <button class="btn btn-danger" style="width: 100%">
                            <a href="{{ url('/admin/reportRoles') }}" style="color:white; text-decoration: none;">Descargar Reporte</a>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-users"></i> Permisos registrados</h2>
                    </div>
                    <div class="inside">
                        <div class="big_count">{{ $permissions }}</div>
                        <hr>
                        <button class="btn btn-danger" style="width: 100%">
                            <a href="{{ url('/admin/reportPermissions') }}" style="color:white; text-decoration: none;">Descargar Reporte</a>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-users"></i> Sedes registradas</h2>
                    </div>
                    <div class="inside">
                        <div class="big_count">{{ $venues-1 }}</div>
                        <hr>
                        <button class="btn btn-danger" style="width: 100%">
                            <a href="#" style="color:white; text-decoration: none;">Descargar Reporte</a>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-users"></i> Carreras registradas</h2>
                    </div>
                    <div class="inside">
                        <div class="big_count">{{ $careers }}</div>
                        <hr>
                        <button class="btn btn-danger" style="width: 100%">
                            <a href="#" style="color:white; text-decoration: none;">Descargar Reporte</a>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-users"></i> Asignaturas registradas</h2>
                    </div>
                    <div class="inside">
                        <div class="big_count">{{ $subjects }}</div>
                        <hr>
                        <button class="btn btn-danger" style="width: 100%">
                            <a href="#" style="color:white; text-decoration: none;">Descargar Reporte</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
        <div class="panel shadow mtop16">
            <div class="header">
                <h2 class="title"><i class="fas fa-home"></i> Graficas</h2>
            </div>
        </div>

        <div class="row mtop16">
            <div class="col-md-4">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-users"></i> Usuarios registrados</h2>
                    </div>
                    <div class="inside">
                        {!! $Userchart->container() !!}
                        <script src="{{ LarapexChart::cdn() }}"></script>
                        {{ $Userchart->script() }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-users"></i> Publicaciones creadas</h2>
                    </div>
                    <div class="inside">
                        {!! $Postchart->container() !!}
                        <script src="{{ LarapexChart::cdn() }}"></script>
                        {{ $Postchart->script() }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-users"></i> Comentarios creados</h2>
                    </div>
                    <div class="inside">
                        {!! $Commentchart->container() !!}
                        <script src="{{ LarapexChart::cdn() }}"></script>
                        {{ $Commentchart->script() }}
                    </div>
                </div>
            </div>
        </div>

@endsection
