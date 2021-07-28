<?php
namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleUser;

trait HasRolesAndPermissions
{
    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if($this->roles->contains('slug', 'admin')){
            return true;
        }
    }
    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class)
            ->withPivot(['user_id','role_id'])->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    /**
     * Check if the user has Role
     *
     * @param [type] $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if( strpos($role, ',') !== false ){//check if this is an list of roles

            $listOfRoles = explode(',',$role);

            foreach ($listOfRoles as $role) {
                if ($this->roles->contains('slug', $role)) {
                    return true;
                }
            }
        }else{
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission($permission)
    {
        if( strpos($permission, ',') !== false ){//check if this is an list of roles

            $listOfPermission = explode(',',$permission);

            foreach ($listOfPermission as $permission) {
                if ($this->$permission->contains('slug', $permission)) {
                    return true;
                }
            }
        }else{
            if ($this->permissions->contains('slug', $permission)) {
                return true;
            }
        }

        return false;
    }
}
