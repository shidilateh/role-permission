<?php

namespace Amdxion\RolePermission;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
// use \Illuminate\Auth\Middleware\Authorize;
use Amdxion\RolePermission\Models\Permission;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;
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

        include __DIR__.'/routes.php';
        $this->registerGates();
        $this->registerPassportTokens();
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
        if(Schema::hasTable('permissions'))
        {

            Gate::before(function ($user, $ability) {
                if ($user->isSuperAdmin()) {
                    return true;
                }
            });

            $permissionss = Permission::pluck('slug');
            
            foreach ($permissionss as $key => $permission) {
                Gate::define($permission, function ($user) use ($permission){
                    return $user->hasAccess([$permission]);
                });
            }
        }
    }

    public function registerPassportTokens()
    {
        Passport::routes();
        if(Schema::hasTable('permissions'))
        {
            $permissions_scopes = Permission::pluck('name','slug')->toArray();
            Passport::tokensCan($permissions_scopes);
        }
    }
}
