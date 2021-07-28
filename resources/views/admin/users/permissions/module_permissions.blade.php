<div class="col-md-4">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fas fa-home"></i>Modulo de Permisos</h2>
        </div>

        <div class="inside">
            @foreach($permisos as $p)
                <div class="form-check">
                    <input type="checkbox" value="{{ $p->id }}" name="{{ $p->slug }}" @if($user->hasPermission($p->slug)) checked @endif> <label for="{{ $p->slug }}">{{ $p->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>
