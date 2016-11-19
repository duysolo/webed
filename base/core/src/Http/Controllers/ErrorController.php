<?php namespace WebEd\Base\Core\Http\Controllers;

class ErrorController extends BaseAdminController
{
    protected $module = 'webed-core';

    public function __construct()
    {
        $this->middleware('webed.auth-admin');

        parent::__construct();

        $this->getDashboardMenu();
    }

    public function getIndex($errorCode)
    {
        $this->breadcrumbs->addLink('Error ' . $errorCode);

        return $this->viewAdmin('errors.' . $errorCode);
    }
}
