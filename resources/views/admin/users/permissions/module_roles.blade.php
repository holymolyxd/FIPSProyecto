<div class="col-md-4">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fas fa-home"></i>Modulo de Roles</h2>
        </div>

        <div class="inside">
            @foreach($role as $r)
                <div class="form-check">
                    <input type="checkbox" value="{{ $r->id }}" name="{{ $r->slug }}" @if($user->hasPermission($r->slug)) checked @endif> <label for="{{ $r->slug }}">{{ $r->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>
