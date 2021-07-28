@extends('admin.master')

@section('title', 'Historial del Rol')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/roles/1') }}"><i class="fas fa-user-tag"></i> Roles</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-history"></i> Historial del Rol</h2>
            </div>

            <div class="inside">
                <table class="table table-bordered table-hover table-responsive-xl">
                    <caption>Cantidad de historiales listados: {{ $history->count() }} @if($history->count() > 1 || $history->count() == 0 ) modificaciones. @else modificacion. @endif</caption>
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Evento</td>
                        <td>Antiguo valor</td>
                        <td>Nuevo valor</td>
                        <td>Usuario responsable</td>
                        <td>Fecha ejecucion</td>
                        <td>Tiempo modificación</td>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $h)
                            <tr>
                                <td>{{ $h->id }}</td>
                                @if($h->event == 'created')
                                    <td>Creado</td>
                                @elseif($h->event == 'deleted')
                                    <td>Eliminado</td>
                                @elseif($h->event == 'updated')
                                    <td>Modificado</td>
                                @elseif($h->event == 'restored')
                                    <td>Restaurado</td>
                                @endif
                                <td>
                                    @foreach($h->old_values as $a => $data)
                                        [{{ $a }}] = {{ $data }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($h->new_values as $a => $data)
                                        [{{ $a }}] = {{ $data }}
                                    @endforeach
                                </td>
                                <td>{{ $h->user->email }}</td>
                                <td>{{ $h->created_at->format('d/m/Y') }}</td>
                                <td>{{ $h->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tr>
                        <td colspan="8">{{ $history->links() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
