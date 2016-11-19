<?php namespace WebEd\Base\Core\Http\Controllers;

class SystemCommandController extends BaseAdminController
{
    protected $module = 'webed-core';

    public function __construct()
    {
        parent::__construct();

        $this->middleware('has-permission:access-dashboard');
    }

    /**
     * Call command composer dump-autoload
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCallDumpAutoload()
    {
        \ModulesManagement::refreshComposerAutoload();
        $this->flashMessagesHelper
            ->addMessages('Composer autoload refreshed', 'success')
            ->showMessagesOnSession();

        return redirect()->back();
    }
}
