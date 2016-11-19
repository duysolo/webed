<?php namespace WebEd\Themes\CleanBlog\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Themes\CleanBlog';

    /**
     * Bootstrap the application services.
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
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        /**
         * Add new page templates
         */
        add_new_template([
            'Homepage',
            'About Us',
            'Contact Us',
        ], 'Page');

        /**
         * Add new category templates
         */
        add_new_template([
            'Blog',
        ], 'Category');
    }
}
