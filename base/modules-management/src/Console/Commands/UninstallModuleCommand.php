<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;

class UninstallModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:uninstall {alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall WebEd module';

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
        /**
         * Migrate tables
         */
        $this->line('Uninstall module dependencies...');
        $this->registerUninstallModuleService();

        $this->info("\nModule " . $this->argument('alias') . " uninstalled.");
    }

    protected function registerUninstallModuleService()
    {
        $module = get_module_information($this->argument('alias'));
        $namespace = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\UninstallModuleServiceProvider');
        if(class_exists($namespace)) {
            $this->app->register($namespace);
            save_module_information($module, [
                'installed' => false
            ]);
        } else {
            $this->line('Nothing to uninstall');
        }
    }
}
