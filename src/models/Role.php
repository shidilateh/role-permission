<?php

namespace Amdxion\RolePermission\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'slug',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function hasAccess(array $permissions) : bool
    {
        // dump($permissions);
        // dump( $this->permissions->pluck('slug'));

        return $this->permissions->whereIn('slug',$permissions)->first() ? true : false ;
        // foreach ($permissions as $permission) {
        //     if ($this->hasPermission($permission))
        //         return true;
        // }
        // return false;
    }

    private function hasPermission(string $permission) : bool
    {
        return $this->permissions->where('slug',$permission)->first() ? true : false ;
    }
}
