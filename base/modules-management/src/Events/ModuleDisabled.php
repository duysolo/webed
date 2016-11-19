<?php namespace WebEd\Base\ModulesManagement\Events;

class ModuleDisabled
{

    /**
     * @var array|string
     */
    public $module;

    /**
     * @param $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }
}
