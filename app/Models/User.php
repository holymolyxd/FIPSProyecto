<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRolesAndPermissions;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    #public function semesters()
    #{
    #    return $this->belongsToMany(Semester::class,'users_semesters')->withTimestamps();
    #}

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'users_subjects')->withTimestamps();
    }

    public function hasSubjects($subject)
    {
        if( strpos($subject, ',') !== false){
            $listOfSemesters = explode(',', $subject);

            foreach ($listOfSemesters as $subject) {
                if ($this->$subject->contains('name', $subject)){
                    return true;
                }
            }
        } else {
            if($this->subjects->contains('name', $subject)){
                return true;
            }
        }
        return false;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
