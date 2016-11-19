<?php namespace WebEd\Base\Core\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\Settings\Http\Controllers\SettingController;

class HookServiceProvider extends ServiceProvider
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->request = request();

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
        add_filter('settings.before-edit.post', function ($data, SettingController $controller) {
            if($controller->request->get('_tab') === 'advanced') {
                $data['construction_mode'] = (int)($this->request->has('construction_mode'));
                $data['show_admin_bar'] = (int)($this->request->has('show_admin_bar'));
            }

            return $data;
        });
    }
}
