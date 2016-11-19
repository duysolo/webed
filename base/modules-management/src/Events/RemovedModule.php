<?php namespace WebEd\Base\ModulesManagement\Events;

class RemovedModule
{

    /**
     * @var array|string
     */
    public $module;

    /**
     * RemovedModule constructor.
     * @param $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }
}
