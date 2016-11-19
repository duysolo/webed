<?php namespace WebEd\Base\ThemesManagement\Console\Generators;

use Illuminate\Console\GeneratorCommand;

abstract class AbstractGenerator extends GeneratorCommand
{
    /**
     * @var array
     */
    protected $moduleInformation;

    /**
     * Get root folder of every modules by module type
     * @param array $type
     * @return string
     */
    protected function resolveModuleRootFolder($module)
    {
        $path = webed_themes_path();
        if (!ends_with('/', $path)) {
            $path .= '/';
        }

        return $path;
    }

    /**
     * Current module information
     * @return array
     */
    protected function getCurrentModule()
    {
        $module = \ThemesManagement::getCurrentTheme();

        if(!$module) {
            $this->error('No theme activated');
            die();
        }

        $moduleRootFolder = $this->resolveModuleRootFolder($module);

        return $this->moduleInformation = array_merge($module, [
            'module-path' => $moduleRootFolder . basename(str_replace('/module.json', '', $module['file'])) . '/'
        ]);
    }

    /**
     * Get module information by key
     * @param $key
     * @return array|mixed
     */
    protected function getModuleInfo($key = null)
    {
        if (!$this->moduleInformation) {
            $this->getCurrentModule();
        }
        if (!$key) {
            return $this->moduleInformation;
        }
        return array_get($this->moduleInformation, $key, null);
    }

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param  string $name
     * @return string
     */
    protected function parseName($name)
    {
        if (str_contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return $this->getDefaultNamespace($name);
    }

    /**
     * Get the destination class path.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        $path = $this->getModuleInfo('module-path') . 'src/' . str_replace('\\', '/', $name) . '.php';

        return $path;
    }

    /**
     * Get the full namespace name for a given class.
     *
     * @param  string $name
     * @return string
     */
    protected function getNamespace($name)
    {
        $namespace = trim(implode('\\', array_slice(explode('\\', $this->getModuleInfo('namespace') . '\\' . str_replace('/', '\\', $name)), 0, -1)), '\\');
        return $namespace;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = class_basename($name);

        return str_replace('DummyClass', $class, $stub);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            'DummyNamespace', $this->getNamespace($name), $stub
        );

        $stub = str_replace(
            'DummyRootNamespace', $this->laravel->getNamespace(), $stub
        );

        if (method_exists($this, 'replaceParameters')) {
            $this->replaceParameters($stub);
        }

        return $this;
    }
}
