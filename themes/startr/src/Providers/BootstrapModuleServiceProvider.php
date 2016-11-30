<?php namespace WebEd\Themes\Startr\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Pages\Repositories\Contracts\PageContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Themes\Startr';

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
         * This template just use one template
         */
        add_new_template([
            'Landing Page'
        ], 'Page');

        cms_theme_options()
            ->addOptionField('front_page', [
                'group' => 'basic',
                'type' => 'select',
                'piority' => 0,
                'label' => 'Front page',
                'helper' => null
            ], function () {
                /**
                 * @var PageRepository $pages
                 */
                $pages = app(PageContract::class);

                $pages = $pages->where('status', '=', 'activated')
                    ->orderBy('order', 'ASC')
                    ->get();

                $pagesArr = [];

                foreach ($pages as $page) {
                    $pagesArr[$page->id] = $page->title;
                }

                return [
                    'front_page',
                    $pagesArr,
                    get_theme_options('front_page'),
                    ['class' => 'form-control']
                ];
            });
    }
}
