<div class="col-md-4 mtop16">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fas fa-home"></i>Modulo de Sliders</h2>
        </div>

        <div class="inside">
            @foreach($slider as $s)
                <div class="form-check">
                    <input type="checkbox" value="{{ $s->id }}" name="{{ $s->slug }}" @if($user->hasPermission($s->slug)) checked @endif> <label for="{{ $s->slug }}">{{ $s->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>

