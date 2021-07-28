<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
class Role extends Model implements AuditableContract
{
    use HasFactory;
    use SoftDeletes;
    use Auditable;

    protected $dates = ['deleted_at'];
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name', 'slug', 'description'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role')
            ->using(PermissionRole::class)
            ->withPivot(['role_id','permission_id'])->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(RoleUser::class)
            ->withPivot(['user_id','role_id'])->withTimestamps();
    }
}
