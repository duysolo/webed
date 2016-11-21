<?php namespace WebEd\Base\Core\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Core\Models\EloquentTranslationsMapper;
use WebEd\Base\Core\Repositories\Contracts\TranslationsMapperContract;
use WebEd\Base\Core\Repositories\TranslationsMapperRepository;
use WebEd\Base\Core\Repositories\TranslationsMapperRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TranslationsMapperContract::class, function () {
            $repository = new TranslationsMapperRepository(new EloquentTranslationsMapper);

            if (config('webed-caching.repository.enabled')) {
                return new TranslationsMapperRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
