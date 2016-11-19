<?php namespace WebEd\Base\Core\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\Core';

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

    private function booted()
    {
        $this->registerMenu();

        $this->generalSettings();
        $this->socialNetworks();
    }

    private function registerMenu()
    {
        /**
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'webed-dashboard',
            'piority' => -999,
            'parent_id' => null,
            'heading' => 'Dashboard',
            'title' => 'Dashboard',
            'font_icon' => 'icon-pie-chart',
            'link' => route('admin::dashboard.index.get'),
            'css_class' => null,
        ]);

        \DashboardMenu::registerItem([
            'id' => 'webed-configuration',
            'piority' => 999,
            'parent_id' => null,
            'heading' => 'Advanced',
            'title' => 'Configurations',
            'font_icon' => 'icon-settings',
            'link' => route('admin::settings.index.get'),
            'css_class' => null,
        ]);
    }

    private function generalSettings()
    {
        cms_settings()
            ->addSettingField('site_title', [
                'group' => 'basic',
                'type' => 'text',
                'piority' => 5,
                'label' => 'Site title',
                'helper' => 'Our site title'
            ], function () {
                return [
                    'site_title',
                    get_settings('site_title'),
                    ['class' => 'form-control']
                ];
            })
            ->addSettingField('site_logo', [
                'group' => 'basic',
                'type' => 'selectImageBox',
                'piority' => 5,
                'label' => 'Site logo',
                'helper' => 'Our site logo'
            ], function () {
                return [
                    'site_logo',
                    get_settings('site_logo'),
                ];
            })
            ->addSettingField('favicon', [
                'group' => 'basic',
                'type' => 'selectImageBox',
                'piority' => 5,
                'label' => 'Favicon',
                'helper' => '16x16, support png, gif, ico, jpg'
            ], function () {
                return [
                    'favicon',
                    get_settings('favicon'),
                ];
            })
            ->addSettingField('construction_mode', [
                'group' => 'advanced',
                'type' => 'customCheckbox',
                'piority' => 5,
                'label' => null,
                'helper' => 'Mark this site on maintenance mode',
            ], function () {
                return [
                    [['construction_mode', '1', 'On construction mode', get_settings('construction_mode'),]],
                ];
            })
            ->addSettingField('show_admin_bar', [
                'group' => 'advanced',
                'type' => 'customCheckbox',
                'piority' => 5,
                'label' => null,
                'helper' => 'When admin logged in, still show admin bar on front site.'
            ], function () {
                return [
                    [['show_admin_bar', '1', 'Show admin bar', get_settings('show_admin_bar')]],
                ];
            });
    }

    private function socialNetworks()
    {
        cms_settings()->addGroup('socials', 'Social networks');

        $socials = [
            'facebook' => [
                'label' => 'Facebook page',
            ],
            'youtube' => [
                'label' => 'Youtube chanel',
            ],
            'twitter' => [
                'label' => 'Twitter page',
            ]
        ];
        foreach ($socials as $key => $row) {
            cms_settings()->addSettingField($key, [
                'group' => 'socials',
                'type' => 'text',
                'piority' => 1,
                'label' => $row['label'],
                'helper' => null
            ], function () use ($key) {
                return [
                    $key,
                    get_settings($key),
                    [
                        'class' => 'form-control',
                        'placeholder' => 'https://',
                        'autocomplete' => 'off'
                    ]
                ];
            });
        }
    }
}
