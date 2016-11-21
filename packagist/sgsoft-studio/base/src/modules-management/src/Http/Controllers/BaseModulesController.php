<?php namespace WebEd\Base\ModulesManagement\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;

abstract class BaseModulesController extends BaseAdminController
{

    public function __construct()
    {
        $this->middleware('has-role:super-admin');

        parent::__construct();
    }
}
