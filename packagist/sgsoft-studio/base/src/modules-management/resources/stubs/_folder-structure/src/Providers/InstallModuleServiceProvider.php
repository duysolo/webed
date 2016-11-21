<?php namespace DummyNamespace\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'DummyNamespace';

    protected $moduleAlias = 'DummyAlias';

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
        $this->createSchema();
        //acl_permission()
        //->registerPermission('Permission 1 description', 'description-1', $this->module)
        //->registerPermission('Permission 2 description', 'description-2', $this->module);
    }

    private function createSchema()
    {
        //Schema::create('field_groups', function (Blueprint $table) {
        //    $table->engine = 'InnoDB';
        //    $table->increments('id');
        //});
    }
}
