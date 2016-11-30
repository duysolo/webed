<?php namespace WebEd\Plugins\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\Blog';

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
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'webed-blog-posts',
            'piority' => 2,
            'parent_id' => null,
            'heading' => 'Blog',
            'title' => 'Posts',
            'font_icon' => 'icon-book-open',
            'link' => route('admin::blog.posts.index.get'),
            'css_class' => null,
        ])
            ->registerItem([
                'id' => 'webed-blog-categories',
                'piority' => 2.1,
                'parent_id' => null,
                'title' => 'Categories',
                'font_icon' => 'fa fa-sitemap',
                'link' => route('admin::blog.categories.index.get'),
                'css_class' => null,
            ]);

        /**
         * Register menu widget
         */
        \MenuManagement::registerWidget('Categories', 'category', function () {
            $categories = get_categories();
            return $this->parseMenuWidgetData($categories);
        });

        /**
         * Register menu link type
         */
        \MenuManagement::registerLinkType('category', function ($id) {
            $category = app(CategoryRepositoryContract::class)
                ->where('id', '=', $id)
                ->first();
            if (!$category) {
                return null;
            }
            return [
                'model_title' => $category->title,
                'url' => route('front.resolve-blog.get', ['slug' => $category->slug]),
            ];
        });
    }

    private function parseMenuWidgetData($categories)
    {
        $result = [];
        foreach ($categories as $category) {
            $result[] = [
                'id' => $category->id,
                'title' => $category->title,
                'children' => $this->parseMenuWidgetData($category->child_cats)
            ];
        }
        return $result;
    }
}
