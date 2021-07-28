<div class="col-md-4">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fas fa-home"></i>Modulo de Usuarios</h2>
        </div>

        <div class="inside">
            @foreach($usuarios as $u)
                <div class="form-check">
                    <input type="checkbox" value="{{ $u->id }}" name="{{ $u->slug }}" @if($user->hasPermission($u->slug)) checked @endif> <label for="{{ $u->slug }}">{{ $u->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>

