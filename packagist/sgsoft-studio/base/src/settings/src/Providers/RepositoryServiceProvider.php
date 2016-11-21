<?php namespace WebEd\Base\Settings\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Settings\Models\EloquentSetting;
use WebEd\Base\Settings\Repositories\SettingRepository;
use WebEd\Base\Settings\Repositories\Contracts\SettingContract;
use WebEd\Base\Settings\Repositories\SettingRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SettingContract::class, function () {
            $repository = new SettingRepository(new EloquentSetting);

            if (config('webed-caching.repository.enabled')) {
                return new SettingRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
