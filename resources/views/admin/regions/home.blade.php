@extends('admin.master')

@section('title', 'Regiones')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ url('/admin/roles/1') }}"><i class="far fa-bookmark"></i> Regiones</a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="far fa-bookmark"></i> Regiones</h2>
            </div>

            <div class="inside">
                <table class="table table-bordered table-hover table-responsive-xl">
                    <caption>Cantidad de regiones listadas: {{ $regions->count() }} @if($regions->count() > 1 || $regions->count() == 0 ) regiones. @else region. @endif</caption>
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>ABR region</td>
                        <td>Nombre region</td>
                        <td>Codigo Romano</td>
                        <td>Orden fisico</td>
                        <td>Fecha de creacion</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($regions as $region)
                        <tr>
                            <td>{{ $region->id }}</td>
                            <td>{{ $region->abr_region }}</td>
                            <td>{{ $region->gloss_region }}</td>
                            <td>{{ $region->code_varchar }}</td>
                            <td>{{ $region->physical_order }}</td>
                            <td>{{ $region->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="opts">

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8">{{ $regions->links() }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
