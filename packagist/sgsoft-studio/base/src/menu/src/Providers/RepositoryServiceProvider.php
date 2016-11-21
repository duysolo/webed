<?php namespace WebEd\Base\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Menu\Models\Menu;
use WebEd\Base\Menu\Models\MenuNode;
use WebEd\Base\Menu\Repositories\Contracts\MenuNodeRepositoryContract;
use WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use WebEd\Base\Menu\Repositories\MenuNodeRepository;
use WebEd\Base\Menu\Repositories\MenuNodeRepositoryCacheDecorator;
use WebEd\Base\Menu\Repositories\MenuRepository;
use WebEd\Base\Menu\Repositories\MenuRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\Menu';

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
        $this->app->bind(MenuRepositoryContract::class, function () {
            $repository = new MenuRepository(new Menu());

            if (config('webed-caching.repository.enabled')) {
                return new MenuRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
        $this->app->bind(MenuNodeRepositoryContract::class, function () {
            $repository = new MenuNodeRepository(new MenuNode());

            if (config('webed-caching.repository.enabled')) {
                return new MenuNodeRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
