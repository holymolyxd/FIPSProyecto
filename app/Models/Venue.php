<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $table = 'venues';

    protected $fillable = [
        'gloss_commune','region_id'
    ];

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function careers()
    {
        return $this->belongsToMany(Career::class,'venues_careers')->withTimestamps();
    }
}
