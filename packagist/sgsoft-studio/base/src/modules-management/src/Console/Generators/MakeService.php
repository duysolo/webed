<?php namespace WebEd\Base\ModulesManagement\Console\Generators;

class MakeService extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make:service
    	{alias : The alias of the module}
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/services/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Services\\' . $this->argument('name');
    }
}
