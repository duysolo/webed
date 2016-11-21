<?php namespace WebEd\Base\Caching\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;

class CachingController extends BaseAdminController
{
    protected $module = 'webed-caching';

    public function __construct()
    {
        parent::__construct();

        $this->middleware('has-permission:view-caching');

        $this->breadcrumbs->addLink('Caching', route('admin::webed-caching.index.get'));

        $this->getDashboardMenu($this->module);

        $this->middleware('has-permission:view-cache');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $this->setPageTitle('Cache management', 'Manage all cms cache');

        $this->assets->addJavascripts('jquery-datatables');

        return do_filter($this->module . '.index.get', $this)->viewAdmin('index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getClearCmsCache()
    {
        $this->middleware('has-permission:clear-cache');

        \Artisan::call('cache:clear');

        $this->flashMessagesHelper
            ->addMessages('Cache cleaned', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::webed-caching.index.get'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRefreshCompiledViews()
    {
        $this->middleware('has-permission:clear-cache');

        \Artisan::call('view:clear');

        $this->flashMessagesHelper
            ->addMessages('Views refreshed', 'success')
            ->showMessagesOnSession();

        return redirect()->to(route('admin::webed-caching.index.get'));
    }
}
