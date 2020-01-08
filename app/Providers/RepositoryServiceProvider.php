<?php
/**
 * Created by PhpStorm.
 * User: lloric
 * Date: 3/5/19
 * Time: 7:03 AM
 */

namespace App\Providers;

use App\Repositories\Auth\Permission\PermissionRepository;
use App\Repositories\Auth\Permission\PermissionRepositoryEloquent;
use App\Repositories\Auth\Role\RoleRepository;
use App\Repositories\Auth\Role\RoleRepositoryEloquent;
use App\Repositories\Auth\User\UserRepository;
use App\Repositories\Auth\User\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            PermissionRepository::class,
            PermissionRepositoryEloquent::class
        );
        $this->app->bind(
            RoleRepository::class,
            RoleRepositoryEloquent::class
        );
        $this->app->bind(
            UserRepository::class,
            UserRepositoryEloquent::class
        );
        //:end-bindings:
    }

}