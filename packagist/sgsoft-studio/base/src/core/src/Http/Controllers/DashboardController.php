<?php namespace WebEd\Base\Core\Http\Controllers;

class DashboardController extends BaseAdminController
{
    protected $module = 'webed-core';

    public function __construct()
    {
        parent::__construct();

        $this->middleware('has-permission:access-dashboard');

        $this->getDashboardMenu('webed-dashboard');
    }

    public function getIndex()
    {
        return do_filter('dashboard.index.get', $this)->viewAdmin('dashboard');
    }
}
