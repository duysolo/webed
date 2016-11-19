<?php namespace WebEd\Plugins\Pages\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Pages\Models\EloquentPage;
use WebEd\Plugins\Pages\Repositories\Contracts\PageContract;
use WebEd\Plugins\Pages\Repositories\PageRepository;
use WebEd\Plugins\Pages\Repositories\PageRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PageContract::class, function () {
            $repository = new PageRepository(new EloquentPage);

            if (config('webed-caching.repository.enabled')) {
                return new PageRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
