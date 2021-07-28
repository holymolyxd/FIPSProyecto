@extends('master')

@section('title', 'Editar mi Perfil')

@section('content')
    <div class="row mtop32">
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fas fa-fingerprint"></i> Contraseña</h2>
                </div>
                <div class="inside">
                    <form action="{{ url('/account/edit/password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="apw">Contraseña Actual:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="far fa-keyboard"></i>
                                    </span>
                                    <input type="password" id="apw" name="apw" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row mtop16">
                            <div class="col-md-12">
                                <label for="npw">Nueva Contraseña:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="far fa-keyboard"></i>
                                    </span>
                                    <input type="password" id="npw" name="npw" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row mtop16">
                            <div class="col-md-12">
                                <label for="cpw">Confirmar Contraseña:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="far fa-keyboard"></i>
                                    </span>
                                    <input type="password" id="cpw" name="cpw" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row mtop16">
                            <div class="col-md-12">
                                <input type="submit" value="Actualizar" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    @if(auth()->user()->hasRole("estudiante"))
        @if(auth()->user()->commune->id != 347)
            <div class="panel shadow mtop16">
                <div class="header">
                    <h2 class="title"><i class="fas fa-university"></i> Agregar Sede</h2>
                </div>
                <div class="inside">
                    <form action="{{ url('/account/edit/venues') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="venue">Sede:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-keyboard"></i>
                                        </span>
                                    </div>
                                    <select name="venue" id="venue" class="selectpicker form-control" title="Selecciona una opción" data-size="8" data-live-search="true" {{ auth()->user()->venue->id != 1 ? 'disabled' : '' }}>
                                        @foreach($venues as $venue)
                                            @if($venue->id != 1)
                                                @if($venue->commune->region == auth()->user()->commune->region)
                                                    <option value="{{ $venue->id }}" {{ auth()->user()->venue->id == $venue->id ? 'selected' : '' }}>{{ $venue->name }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->venue->id == 1)
                            <div class="row mtop16">
                                <div class="col-md-12">
                                    <input type="submit" value="Guardar" class="btn btn-success">
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

        @if(auth()->user()->venue->id != 1)
            <div class="panel shadow mtop16">
                <div class="header">
                    <h2 class="title"><i class="fas fa-book"></i> Agregar Carrera</h2>
                </div>
                <div class="inside">
                    <form action="{{ url('/account/edit/careers') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="career">Carrera:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-keyboard"></i>
                                        </span>
                                    </div>
                                    <select name="career" id="career" class="selectpicker form-control" title="Selecciona una opción" data-size="8" data-live-search="true" {{ auth()->user()->career_id != 0 ? 'disabled' : '' }}>
                                        @foreach(auth()->user()->venue->careers as $career)
                                            @if($venue->id != 1)
                                                <option value="{{ $career->id }}" {{ auth()->user()->career_id == $career->id ? 'selected' : '' }}>{{ $career->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->career_id == 0)
                            <div class="row mtop16">
                                <div class="col-md-12">
                                    <input type="submit" value="Guardar" class="btn btn-success">
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            @if(auth()->user()->career_id !== 0)
                <div class="panel shadow mtop16">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-hashtag"></i> Agregar Semestre</h2>
                    </div>
                    <div class="inside">
                        <form action="{{ url('/account/edit/semester') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="semester">Semestre:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-keyboard"></i>
                                    </span>
                                        </div>
                                        <select name="semester" id="semester" class="selectpicker form-control" title="Selecciona una opción" data-size="8" data-live-search="true"
                                                {{ auth()->user()->semester_id != 9 ? 'disabled' : '' }} >
                                            @foreach(auth()->user()->career->semesters as $semester)
                                                <option value="{{ $semester->id }}" {{ auth()->user()->semester_id == $semester->id ? 'selected' : ''  }}>{{ $semester->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if(auth()->user()->semester_id == 9 )
                                <div class="row mtop16">
                                    <div class="col-md-12">
                                        <input type="submit" value="Guardar" class="btn btn-success">
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            @endif
            @endif
        @endif
    @endif
</div>

<div class="col-md-9">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fas fa-address-card"></i> Editar Información personal</h2>
        </div>
        <div class="inside">
            <form action="{{ url('/account/edit/info') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="rut">RUT:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="far fa-keyboard"></i>
                            </span>
                            <input type="text" name="rut" id="rut" class="form-control" value="{{ Rut::parse(auth()->user()->rut)->format() }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="name">Nombre:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="far fa-keyboard"></i>
                            </span>
                            <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="email">Correo electronico:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="far fa-keyboard"></i>
                            </span>
                            <input type="text" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row mtop16">
                    <div class="col-md-4">
                        <label for="phone">Telefono:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="far fa-keyboard"></i>
                            </span>
                            <input type="number" class="form-control" id="phone" name="phone" value="{{ auth()->user()->phone }}" @if(!is_null(auth()->user()->phone)) disabled @endif>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="birthdate">Fecha de Nacimiento:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="far fa-keyboard"></i>
                            </span>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ auth()->user()->birthdate }}" @if(!is_null(auth()->user()->birthdate)) disabled @endif>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="gender">Genero:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            <select name="gender" id="gender" class="selectpicker form-control" title="Selecciona una opción" data-size="3" {{ auth()->user()->gender->id != 1 ? 'disabled' : '' }}>
                                @foreach($genders as $g)
                                    @if($g->id == 2 || $g->id == 3)
                                        <option value="{{ $g->id }}" {{ auth()->user()->gender->id == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->gender->id == 1 && is_null(auth()->user()->birthdate) && is_null(auth()->user()->phone))
                    <div class="row mtop16">
                        <div class="col-md-12">
                            <input type="submit" value="Guardar" class="btn btn-success">
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="panel shadow mtop16">
        <div class="header">
            <h2 class="title"><i class="fas fa-map-marker"></i> Agregar ubicacion</h2>
        </div>
        <div class="inside">
            <form action="{{ url('/account/edit/adress') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="adress">Direccion:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="far fa-keyboard"></i>
                            </span>
                            <input type="text" name="adress" id="adress" class="form-control" value="{{ auth()->user()->adress }}" @if(!is_null(auth()->user()->adress)) disabled @endif>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="commune">Comuna:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                            <select name="commune" id="commune" class="selectpicker form-control" title="Selecciona una opción" data-size="8" data-live-search="true" {{ auth()->user()->commune->id != 347 ? 'disabled' : ''}}>
                                @foreach($communes as $commune)
                                    @if($commune->id != 347)
                                        <option value="{{ $commune->id }}" {{ auth()->user()->commune->id == $commune->id ? 'selected' : '' }}>{{ $commune->gloss_commune }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->commune->id == 347 && is_null(auth()->user()->adress))
                    <div class="row mtop16">
                        <div class="col-md-12">
                            <input type="submit" value="Guardar" class="btn btn-success">
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
    @if(auth()->user()->hasRole("estudiante"))
        @if(auth()->user()->semester_id != 9 )
            @if(count(auth()->user()->subjects) == 0)
                <div class="panel shadow mtop16">
                    <div class="header">
                        <h2 class="title"><i class="fas fa-book-open"></i> Agregar Asignaturas</h2>
                    </div>
                    <div class="inside">
                        <form action="{{ url('/account/edit/subject') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="subject">Asignaturas:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-keyboard"></i>
                                            </span>
                                    </div>
                                    <select name="subject[]" multiple id="subject" class="selectpicker form-control" title="Selecciona una opción" data-size="8" data-live-search="true" {{ count(auth()->user()->subjects) >= 1 ? 'disabled' : '' }}>
                                        @foreach($careers as $career)
                                            @if($career->id == auth()->user()->career_id)
                                                @foreach($career->subjects as $subject)
                                                    @foreach($subject->semesters as $semester)
                                                        @if(auth()->user()->semester_id != 9)
                                                            @if($semester->id == auth()->user()->semester_id || $semester->id == auth()->user()->semester_id-1)
                                                                <option value="{{$subject->id }}" {{ auth()->user()->hasSubjects($subject->name) ? 'selected' : ''  }}>{{ $subject->name }}</option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if(count(auth()->user()->subjects) == 0)
                            <div class="row mtop16">
                                <div class="col-md-12">
                                    <input type="submit" value="Guardar" class="btn btn-success">
                                </div>
                            </div>
                        @endif
                        </form>
                    </div>
                </div>
        @endif

        @if(count(auth()->user()->subjects) >= 1)
        <div class="panel shadow mtop16">
            <div class="header">
                <h2 class="title"><i class="fas fa-book-open"></i> Mis asignaturas</h2>
            </div>
            <div class="inside">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Asignatura</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(auth()->user()->subjects as $subject)
                        <tr>
                            <td>{{ $subject->id }}</td>
                            <td>{{ $subject->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @endif
    @endif
</div>
</div>
@endsection
