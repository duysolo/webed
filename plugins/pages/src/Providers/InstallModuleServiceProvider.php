<?php namespace WebEd\Plugins\Pages\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\Pages';

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
        app()->booted(function () {
            $this->booted();
        });
    }

    private function booted()
    {
        $this->createSchema();

        acl_permission()
            ->registerPermission('View pages', 'view-pages', $this->module)
            ->registerPermission('Create page', 'create-pages', $this->module)
            ->registerPermission('Edit page', 'edit-pages', $this->module)
            ->registerPermission('Delete pages', 'delete-pages', $this->module);
    }

    private function createSchema()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('page_template', 255)->nullable();
            $table->string('slug', 255)->nullable()->unique();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->string('keywords', 255)->nullable();
            $table->enum('status', ['activated', 'disabled'])->default('activated');
            $table->integer('order')->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }
}
