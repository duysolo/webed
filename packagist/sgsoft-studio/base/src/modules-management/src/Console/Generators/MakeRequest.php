<?php namespace WebEd\Base\ModulesManagement\Console\Generators;

class MakeRequest extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:request
    	{alias : The alias of the module}
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/requests/request.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Http\\Requests\\' . $this->argument('name');
    }
}
