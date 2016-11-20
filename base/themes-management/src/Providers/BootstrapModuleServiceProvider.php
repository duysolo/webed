<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use WebEd\Base\Menu\Repositories\MenuRepository;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\ThemesManagement';

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
            'id' => 'webed-themes-management',
            'piority' => 1002,
            'parent_id' => null,
            'heading' => null,
            'title' => 'Themes',
            'font_icon' => 'icon-magic-wand',
            'link' => route('admin::themes.index.get'),
            'css_class' => null,
        ]);

        cms_settings()
            ->addSettingField('top_menu', [
                'group' => 'theme-options',
                'type' => 'select',
                'piority' => 3,
                'label' => 'Select the top menu of site',
                'helper' => 'Our site menu'
            ], function () {
                /**
                 * @var MenuRepository $menus
                 */
                $menus = app(MenuRepositoryContract::class);
                $menus = $menus->where('status', '=', 'activated')
                    ->get();

                $menusArr = [];

                foreach ($menus as $menu) {
                    $menusArr[$menu->slug] = $menu->title;
                }

                return [
                    'top_menu',
                    $menusArr,
                    get_settings('top_menu'),
                    ['class' => 'form-control']
                ];
            });
    }
}
