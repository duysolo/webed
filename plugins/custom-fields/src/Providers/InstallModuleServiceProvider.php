<?php namespace WebEd\Plugins\CustomFields\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\CustomFields';

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

        acl_permission()
            ->registerPermission('View custom fields', 'view-custom-fields', $this->module)
            ->registerPermission('Create field group', 'create-field-groups', $this->module)
            ->registerPermission('Edit field group', 'edit-field-groups', $this->module)
            ->registerPermission('Delete field group', 'delete-field-groups', $this->module);
    }

    private function createSchema()
    {
        Schema::create('field_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 255);
            $table->text('rules')->nullable();
            $table->enum('status', ['activated', 'disabled']);
            $table->integer('order')->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('field_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('field_group_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('order')->default(0)->nullable();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->string('type', 100);
            $table->text('instructions')->nullable();
            $table->text('options')->nullable();
            $table->unique(['field_group_id', 'parent_id', 'slug']);

            $table->foreign('field_group_id')->references('id')->on('field_groups')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('field_items')->onDelete('cascade');
        });

        Schema::create('custom_fields', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('use_for', 255);
            $table->integer('use_for_id')->unsigned();
            $table->integer('field_item_id')->unsigned();
            $table->string('type', 255);
            $table->string('slug', 255);
            $table->text('value')->nullable();

            $table->foreign('field_item_id')->references('id')->on('field_items')->onDelete('cascade');
        });
    }
}
