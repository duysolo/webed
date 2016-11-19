<?php namespace WebEd\Base\ThemesManagement\Console\Commands;

use Illuminate\Console\Command;

class DisableThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:disable {alias : Theme alias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable theme';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \ThemesManagement::disableTheme($this->argument('alias'))->refreshComposerAutoload();

        $this->info("Your theme disabled successfully.");
    }
}
