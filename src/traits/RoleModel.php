<?php

namespace Amdxion\RolePermission\Traits;

use Amdxion\RolePermission\Models\Role;

trait RoleModel
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }


    /**
     * Checks if the user belongs to role.
     */
    public function inRole(string $roleSlug)
    {
        return $this->roles->where('slug',$roleSlug)->count() ?? false ;
    }

    
    public function isSuperAdmin()
    {
        return $this->inRole("admin");
    }


    /**
     * Checks if User has access to $permissions.
     */
    public function hasAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        foreach ($this->roles as $role) 
        {   
            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }
}
