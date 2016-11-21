<?php namespace WebEd\Base\Core\Http\ViewComposers;

use Illuminate\View\View;

class AdminBreadcrumbs
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('pageBreadcrumbs', \Breadcrumbs::render());
    }
}
