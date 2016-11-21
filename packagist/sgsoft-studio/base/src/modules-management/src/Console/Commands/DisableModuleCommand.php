<?php namespace WebEd\Base\ModulesManagement\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;

class DisableModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:disable {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable plugins';

    /**
     * @var array
     */
    protected $container = [];


    /**
     * @var Composer
     */
    protected $composer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
        $this->composer->setWorkingPath(base_path());
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->getInformation();

        $count = 0;

        $plugins = get_modules_by_type('plugins');

        if(!$this->container['alias']) {
            foreach ($plugins as $plugin) {
                \ModulesManagement::disableModule(array_get($plugin, 'alias'));
                $count++;
            }
        } else {
            $plugins = $plugins->where('alias', '=', $this->container['alias']);
            foreach ($plugins as $plugin) {
                \ModulesManagement::disableModule(array_get($plugin, 'alias'));
                $count++;
            }
        }

        echo PHP_EOL;

        \ModulesManagement::refreshComposerAutoload();

        $this->info("\n$count module(s) disabled successfully.");
    }

    protected function getInformation()
    {
        if($this->option('all')) {
            $this->container['alias'] = null;
        } else {
            $this->container['alias'] = $this->ask('Plugin alias');
        }
    }
}
