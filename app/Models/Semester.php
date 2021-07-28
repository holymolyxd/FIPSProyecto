<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semesters';

    protected $fillable = [
        'name'
    ];

    public function careers()
    {
        return $this->belongsToMany(Career::class,'semesters_careers')->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class,'users_semesters')->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'subjects_semesters')->withTimestamps();
    }
}
