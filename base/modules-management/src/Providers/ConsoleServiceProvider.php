<?php namespace WebEd\Base\ModulesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\ModulesManagement';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->generatorCommands();
        $this->otherCommands();
    }

    private function generatorCommands()
    {
        $generators = [
            'webed.console.generator.make-module' => \WebEd\Base\ModulesManagement\Console\Generators\MakeModule::class,
            'webed.console.generator.make-provider' => \WebEd\Base\ModulesManagement\Console\Generators\MakeProvider::class,
            'webed.console.generator.make-controller' => \WebEd\Base\ModulesManagement\Console\Generators\MakeController::class,
            'webed.console.generator.make-middleware' => \WebEd\Base\ModulesManagement\Console\Generators\MakeMiddleware::class,
            'webed.console.generator.make-request' => \WebEd\Base\ModulesManagement\Console\Generators\MakeRequest::class,
            'webed.console.generator.make-model' => \WebEd\Base\ModulesManagement\Console\Generators\MakeModel::class,
            'webed.console.generator.make-repository' => \WebEd\Base\ModulesManagement\Console\Generators\MakeRepository::class,
            'webed.console.generator.make-facade' => \WebEd\Base\ModulesManagement\Console\Generators\MakeFacade::class,
            'webed.console.generator.make-service' => \WebEd\Base\ModulesManagement\Console\Generators\MakeService::class,
            'webed.console.generator.make-support' => \WebEd\Base\ModulesManagement\Console\Generators\MakeSupport::class,
            'webed.console.generator.make-view' => \WebEd\Base\ModulesManagement\Console\Generators\MakeView::class,
            'webed.console.generator.make-migration' => \WebEd\Base\ModulesManagement\Console\Generators\MakeMigration::class,
            'webed.console.generator.make-command' => \WebEd\Base\ModulesManagement\Console\Generators\MakeCommand::class,
        ];
        foreach ($generators as $slug => $class) {
            $this->app->singleton($slug, function ($app) use ($slug, $class) {
                return $app[$class];
            });

            $this->commands($slug);
        }
    }

    private function otherCommands()
    {
        $commands = [
            'webed.console.command.cms-install' => \WebEd\Base\ModulesManagement\Console\Commands\InstallCmsCommand::class,
            'webed.console.command.module-install' => \WebEd\Base\ModulesManagement\Console\Commands\InstallModuleCommand::class,
            'webed.console.command.module-uninstall' => \WebEd\Base\ModulesManagement\Console\Commands\UninstallModuleCommand::class,
            'webed.console.command.disable-module' => \WebEd\Base\ModulesManagement\Console\Commands\DisableModuleCommand::class,
            'webed.console.command.enable-module' => \WebEd\Base\ModulesManagement\Console\Commands\EnableModuleCommand::class,
        ];
        foreach ($commands as $slug => $class) {
            $this->app->singleton($slug, function ($app) use ($slug, $class) {
                return $app[$class];
            });

            $this->commands($slug);
        }
    }
}
