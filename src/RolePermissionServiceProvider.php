<?php

namespace Amdxion\RolePermission;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
// use \Illuminate\Auth\Middleware\Authorize;
use Amdxion\RolePermission\Models\Permission;
use Illuminate\Support\Facades\Schema;
use Artisan;

class RolePermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        $this->publishes([
            __DIR__.'/migrations' => database_path('migrations'),
        ], 'migrations');

        include __DIR__.'/routes.php';
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
        if(Schema::hasTable('Permission'))
        {
            $permissionss = Permission::pluck('slug');

            foreach ($permissionss as $key => $permission) {
                Gate::define($permission, function ($user) use ($permission){
                    return $user->hasAccess([$permission]);
                });
            }
        }

        Gate::before(function ($user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
    }
}
