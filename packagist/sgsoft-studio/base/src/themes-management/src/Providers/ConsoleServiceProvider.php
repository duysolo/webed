<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
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
            'webed.console.generator.theme.make-theme' => \WebEd\Base\ThemesManagement\Console\Generators\MakeTheme::class,
            'webed.console.generator.theme.make-controller' => \WebEd\Base\ThemesManagement\Console\Generators\MakeController::class,
            'webed.console.generator.theme.make-view' => \WebEd\Base\ThemesManagement\Console\Generators\MakeView::class,
            'webed.console.generator.theme.make-command' => \WebEd\Base\ThemesManagement\Console\Generators\MakeCommand::class,
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
            'webed.console.command.theme.enable-theme' => \WebEd\Base\ThemesManagement\Console\Commands\EnableThemeCommand::class,
            'webed.console.command.theme.disable-theme' => \WebEd\Base\ThemesManagement\Console\Commands\DisableThemeCommand::class,
            'webed.console.command.theme.install-theme' => \WebEd\Base\ThemesManagement\Console\Commands\InstallThemeCommand::class,
            'webed.console.command.theme.uninstall-theme' => \WebEd\Base\ThemesManagement\Console\Commands\UninstallThemeCommand::class,
        ];
        foreach ($commands as $slug => $class) {
            $this->app->singleton($slug, function ($app) use ($slug, $class) {
                return $app[$class];
            });

            $this->commands($slug);
        }
    }
}
