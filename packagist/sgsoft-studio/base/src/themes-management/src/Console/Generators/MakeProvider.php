<?php namespace WebEd\Base\ThemesManagement\Console\Generators;

class MakeProvider extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:provider
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Provider';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/providers/provider.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Providers\\' . $this->argument('name');
    }
}
