<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $table = 'careers';

    protected $fillable = [
        'name'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function venues()
    {
        return $this->belongsToMany(Venue::class,'venues_careers')->withTimestamps();
    }

    public function semesters()
    {
        return $this->belongsToMany(Semester::class, 'semesters_careers')->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'careers_subjects')->withTimestamps();
    }
}
