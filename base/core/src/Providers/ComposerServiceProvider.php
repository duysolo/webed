<?php namespace WebEd\Base\Core\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Core\Http\ViewComposers\AdminBreadcrumbs;

class ComposerServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\Core';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'webed-core::admin._partials.breadcrumbs',
        ], AdminBreadcrumbs::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
