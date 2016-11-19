<?php namespace WebEd\Plugins\CustomFields\Providers;

use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    public function boot()
    {
        add_action(
            'meta_boxes',
            [\WebEd\Plugins\CustomFields\Hook\Actions\Render\MappingActionsByType::class, 'handle'],
            20
        );

        add_action(
            'pages.after-edit.post',
            [\WebEd\Plugins\CustomFields\Hook\Actions\Store\Pages::class, 'afterSaveContent'],
            20
        );

        add_action(
            'footer_js',
            [\WebEd\Plugins\CustomFields\Hook\Actions\AssetsInjection::class, 'renderJs'],
            20
        );

        /**
         * Register blog actions
         */
        add_action(
            'blog.posts.after-edit.post',
            [\WebEd\Plugins\CustomFields\Hook\Actions\Store\Posts::class, 'afterSaveContent'],
            20
        );
        add_action(
            'blog.categories.after-edit.post',
            [\WebEd\Plugins\CustomFields\Hook\Actions\Store\Categories::class, 'afterSaveContent'],
            20
        );
    }
}
