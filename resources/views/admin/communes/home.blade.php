@extends('admin.master')

@section('title', 'Comunas')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/roles/1') }}"><i class="fas fa-location-arrow"></i> Comunas</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fas fa-location-arrow"></i> Comunas</h2>
            </div>

            <div class="inside">
                <table class="table table-bordered table-hover table-responsive-xl">
                    <caption>Cantidad de comunas listadas: {{ $communes->count() }} @if($communes->count() > 1 || $communes->count() == 0 ) comunas. @else comuna. @endif</caption>
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Codigo Comuna</td>
                        <td>Nombre Comuna</td>
                        <td>Region</td>
                        <td>Fecha de creacion</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($communes as $commune)
                        <tr>
                            <td>{{ $commune->id }}</td>
                            <td>{{ $commune->cod_commune }}</td>
                            <td>{{ $commune->gloss_commune }}</td>
                            <td>{{ $commune->region->gloss_region }}</td>
                            <td>{{ $commune->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="opts">

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">{{ $communes->links() }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
