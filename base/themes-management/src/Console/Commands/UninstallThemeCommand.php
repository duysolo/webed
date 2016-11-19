<?php namespace WebEd\Base\ThemesManagement\Console\Commands;

use Illuminate\Console\Command;

class UninstallThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:uninstall {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall WebEd theme';

    /**
     * @var array
     */
    protected $container = [];

    /**
     * @var array
     */
    protected $dbInfo = [];

    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->app = app();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $theme = get_theme_information($this->argument('alias'));
        if(!$theme) {
            $this->error('Theme not exists');
            die();
        }

        $this->line('Uninstall module dependencies...');
        $this->registerUninstallModuleService($theme);

        $this->info("\nTheme " . $this->argument('alias') . " uninstalled.");
    }

    protected function registerUninstallModuleService($theme)
    {
        $namespace = str_replace('\\\\', '\\', array_get($theme, 'namespace', '') . '\Providers\UninstallModuleServiceProvider');
        if(class_exists($namespace)) {
            $this->app->register($namespace);
            save_theme_information($theme, [
                'installed' => false
            ]);
        } else {
            $this->line('Nothing to uninstall');
        }
    }
}
