<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Users\Models\EloquentUser;
use WebEd\Base\Users\Repositories\UserRepositoryCacheDecorator;
use WebEd\Base\Users\Repositories\UserRepository;
use WebEd\Base\Users\Repositories\Contracts\UserContract;

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
        $this->app->bind(UserContract::class, function () {
            $repository = new UserRepository(new EloquentUser);

            if (config('webed-caching.repository.enabled')) {
                return new UserRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
