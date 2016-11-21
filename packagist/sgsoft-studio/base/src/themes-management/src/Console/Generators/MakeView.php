<?php namespace WebEd\Base\ThemesManagement\Console\Generators;

class MakeView extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:view
    	{name : View name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    protected $viewExtendsFrom;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/views/view.stub';
    }

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

        $this->info($this->type . ' created successfully.');
    }

    /**
     * Get the destination class path.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        $path = $this->getModuleInfo('module-path') . 'resources/views/' . str_replace('\\', '/', $name) . '.blade.php';

        return $path;
    }

    protected function replaceParameters(&$stub)
    {
        $stub = str_replace([
            '{alias}',
            'ViewExtendsFrom',
        ], [
            array_get($this->moduleInformation, 'alias'),
            'webed-theme-' . array_get($this->moduleInformation, 'alias') . '::front._master',
        ], $stub);
    }
}
