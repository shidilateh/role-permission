<?php

namespace Amdxion\RolePermission;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
// use \Illuminate\Auth\Middleware\Authorize;
use Amdxion\RolePermission\Models\Permission;

class RolePermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        include __DIR__.'/routes.php';
        // $router->middleware(Authorize::class);
        $this->registerGates();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Amdxion\RolePermission\Controllers\RolePermissionController');
        $this->loadViewsFrom(__DIR__.'/views', 'role-permission');

    }

    public function registerGates()
    {
        $permissionss = Permission::pluck('slug');

        Gate::before(function ($user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        foreach ($permissionss as $key => $permission) {
            Gate::define($permission, function ($user) use ($permission){
                return $user->hasAccess([$permission]);
            });
        }
    }
}