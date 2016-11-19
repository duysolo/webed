<?php namespace WebEd\Base\ThemesManagement\Console\Generators;

class MakeCommand extends AbstractGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:command
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Command';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/console/command.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Console\\Commands\\' . $this->argument('name');
    }
}
