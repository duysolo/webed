<?php namespace WebEd\Base\ModulesManagement\Console\Generators;

class MakeModel extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:model
    	{alias : The alias of the module}
    	{name : The class name}
    	{table : The table name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    protected $buildContract = false;

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $nameInput = $this->getNameInput();

        $name = $this->parseName($nameInput);

        $path = $this->getPath($name);

        if ($this->alreadyExists($nameInput)) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        /**
         * Create model contract
         */
        $this->buildContract = true;
        $contractName = 'Contracts/' . get_file_name($path, '.php');
        $contractPath = get_base_folder($path) . $contractName . 'ModelContract.php';

        $this->makeDirectory($contractPath);

        $this->files->put($contractPath, $this->buildClass('Models\\' . $contractName));

        $this->info($this->type . ' created successfully.');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->buildContract === true) {
            return __DIR__ . '/../../../resources/stubs/models/model.contract.stub';
        }
        return __DIR__ . '/../../../resources/stubs/models/model.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->buildContract === true) {
            return 'Models\\Contracts\\' . $this->argument('name');
        }
        return 'Models\\' . $this->argument('name');
    }

    protected function replaceParameters(&$stub)
    {
        $stub = str_replace([
            '{table}',
        ], [
            $this->argument('table'),
        ], $stub);
    }
}
