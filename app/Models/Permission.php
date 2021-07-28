<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Permission extends Model implements AuditableContract
{
    use HasFactory;
    use SoftDeletes;
    use Auditable;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
      'name', 'slug', 'description'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->using(PermissionRole::class)
            ->withPivot(['role_id', 'permission_id'])->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(PermissionUser::class)
            ->withPivot(['user_id', 'permission_id'])->withTimestamps();
    }

    public function permissionHasRole($role_name)
    {
        foreach ($this->roles as $permission){
            if (Str::lower($role_name) == Str::lower($permission->name))
            {
                return true;
            }
        }
        return false;
    }
}
