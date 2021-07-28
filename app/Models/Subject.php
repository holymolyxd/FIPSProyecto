<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'name'
    ];

    public function careers()
    {
        return $this->belongsToMany(Career::class,'careers_subjects')->withTimestamps();
    }

    public function semesters()
    {
        return $this->belongsToMany(Semester::class, 'subjects_semesters')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'users_subjects')->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
