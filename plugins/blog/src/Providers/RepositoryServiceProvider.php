<?php namespace WebEd\Plugins\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Blog\Models\Category;
use WebEd\Plugins\Blog\Models\Post;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\CategoryRepositoryCacheDecorator;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;
use WebEd\Plugins\Blog\Repositories\PostRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\Blog';

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
        $this->app->bind(PostRepositoryContract::class, function () {
            $repository = new PostRepository(new Post());

            if (config('webed-caching.repository.enabled')) {
                return new PostRepositoryCacheDecorator($repository);
            }

            return $repository;
        });

        $this->app->bind(CategoryRepositoryContract::class, function () {
            $repository = new CategoryRepository(new Category());

            if (config('webed-caching.repository.enabled')) {
                return new CategoryRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
