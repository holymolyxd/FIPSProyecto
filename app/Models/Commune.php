<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $table = 'communes';

    protected $fillable = [
        'gloss_commune','region_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function venues()
    {
        return $this->hasMany(Venue::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
