@extends('master')
@section('title','Crear publicacion')
@section('content')
    <div class="row mtop32">
        <div class="col-md-12">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fas fa-fingerprint"></i> Crear publicación</h2>
                </div>
                <div class="inside">
                    <form action="{{ url('/post/add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="title">Titulo de la publicación:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="far fa-keyboard"></i>
                                    </span>
                                    <input type="text" id="title" name="title" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row mtop16">
                            <div class="col-md-12">
                                <label for="detail">Contenido de la publicación:</label>
                                <div class="input-group">
                                    <textarea name="detail" id="detail" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mtop16">
                            <div class="col-md-12">
                                <label for="subject">Asignaturas:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-keyboard"></i>
                                        </span>
                                    </div>
                                    <select name="subject" id="subject" class="selectpicker form-control" title="Selecciona una opción" data-size="8" data-live-search="true">
                                        @foreach(auth()->user()->subjects as $su)
                                            <option value="{{ $su->id }}">{{ $su->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-12">
                                <input type="submit" value="Guardar" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
