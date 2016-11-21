<?php namespace WebEd\Base\ACL\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\ACL\Models\EloquentPermission;
use WebEd\Base\ACL\Models\EloquentRole;
use WebEd\Base\ACL\Repositories\Contracts\PermissionContract;
use WebEd\Base\ACL\Repositories\Contracts\RoleContract;
use WebEd\Base\ACL\Repositories\PermissionRepository;
use WebEd\Base\ACL\Repositories\PermissionRepositoryCacheDecorator;
use WebEd\Base\ACL\Repositories\RoleRepository;
use WebEd\Base\ACL\Repositories\RoleRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoleContract::class, function () {
            $repository = new RoleRepository(new EloquentRole);

            if (config('webed-caching.repository.enabled')) {
                return new RoleRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
        $this->app->bind(PermissionContract::class, function () {
            $repository = new PermissionRepository(new EloquentPermission);

            if (config('webed-caching.repository.enabled')) {
                return new PermissionRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
