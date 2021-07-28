<div class="col-md-4 mtop16">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fas fa-home"></i>Modulo de Dashboard</h2>
        </div>

        <div class="inside">
            @foreach($dashboard as $d)
                <div class="form-check">
                        <input type="checkbox" value="{{ $d->id }}" name="{{ $d->slug }}" @if($user->hasPermission($d->slug)) checked @endif> <label for="{{ $d->slug }}">{{ $d->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>
