<?php namespace WebEd\Themes\Startr\Providers;

use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Callback when app booted
     *
     * @return void
     */
    private function booted()
    {
        add_filter('front.default-homepage.get', function ($pageId) {
            $frontPage = get_theme_options('front_page');
            if(!$frontPage) {
                return $pageId;
            }
            return $frontPage;
        });
    }
}
