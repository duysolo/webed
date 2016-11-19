<?php namespace WebEd\Plugins\CustomFields\Hook\Actions\Render;

use WebEd\Base\Core\Models\Contracts\BaseModelContract;

class MappingActionsByType
{
    /**
     * @var string
     */
    protected $namespace = 'WebEd\Plugins\CustomFields\Hook\Actions\Render\\';

    /**
     * @var array
     */
    protected $mapping = [
        'page' => 'Pages',
        'blog.post' => 'Posts',
        'blog.category' => 'Categories',
    ];

    /**
     * @var mixed
     */
    protected $rendererClass;

    /**
     * @param string $location: type of the current object. Currently support the type in $this->mapping
     * @param string $type
     * @param BaseModelContract $item
     */
    public function handle($location, $type, BaseModelContract $item = null)
    {
        /**
         * Just render custom fields for main meta box
         */
        if ($location !== 'main' || !$item) {
            return;
        }

        $class = array_get($this->mapping, $type, null);

        if (!$class) {
            return;
        }

        $class = $this->namespace . $class;

        $this->rendererClass = app($class);

        $this->rendererClass->render($type, $item);
    }
}
