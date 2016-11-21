<?php namespace WebEd\Base\ModulesManagement\Console\Generators;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;

class MakeMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:migration 
        {alias : The alias of module}
        {name : The name of the migration.}
        {--create : The table to be created.}
        {--table= : The table to migrate.}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Make migration';

    /**
     * The migration creator instance.
     *
     * @var \Illuminate\Database\Migrations\MigrationCreator
     */
    protected $creator;

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new migration install command instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationCreator $creator
     * @param  \Illuminate\Support\Composer $composer
     * @return void
     */
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        parent::__construct();

        $this->creator = $creator;
        $this->composer = $composer;
        $this->composer->setWorkingPath(base_path());
    }

    public function fire()
    {
        // It's possible for the developer to specify the tables to modify in this
        // schema operation. The developer may also specify if this table needs
        // to be freshly created so we can create the appropriate migrations.
        $name = trim($this->argument('name'));

        $table = $this->option('table');

        $create = $this->option('create') ?: false;

        if (! $table && is_string($create)) {
            $table = $create;

            $create = true;
        }

        // Now we are ready to write the migration out to disk. Once we've written
        // the migration out, we will dump-autoload for the entire framework to
        // make sure that the migrations are registered by the class loaders.
        $this->writeMigration($name, $table, $create);
    }

    /**
     * Write the migration file to disk.
     *
     * @param  string $name
     * @param  string $table
     * @param  bool $create
     * @return string
     */
    protected function writeMigration($name, $table, $create)
    {
        $path = $this->getMigrationPath();

        $file = pathinfo($this->creator->create($name, $path, $table, $create), PATHINFO_FILENAME);

        return $this->line("<info>Created Migration:</info> {$file}");
    }

    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        $module = get_module_information($this->argument('alias'));
        $baseDir = get_base_folder(array_get($module, 'file'));
        $path = $baseDir . 'database/migrations';
        return $path;
    }
}
