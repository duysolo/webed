<?php namespace WebEd\Base\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var \WebEd\Base\Core\Repositories\AbstractBaseRepository
     */
    protected $repository;

    /**
     * @var string
     */
    public $adminRoute;

    /**
     * Specify all variables will be passed to view
     * @var array
     */
    public $dis = [];

    /**
     * All cms settings
     * @var array
     */
    protected $CMSSettings;

    public function __construct()
    {
        $this->request = request();

        $this->adminRoute = config('webed.admin_route');
        view()->share('adminRoute', $this->adminRoute);

        $this->CMSSettings = get_settings();

        view()->share('CMSSettings', $this->CMSSettings);
    }

    /**
     * Set css class for body
     * @param string $class
     */
    public function setBodyClass($class)
    {
        view()->share([
            'bodyClass' => $class,
        ]);
    }

    /**
     * Set page title
     * @param $title
     * @param null $subTitle
     */
    public function setPageTitle($title, $subTitle = null)
    {
        view()->share([
            'pageTitle' => $title,
            'subPageTitle' => $subTitle,
        ]);
    }

    /**
     * @param $viewName
     * @param null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($viewName, $data = null)
    {
        if ($data === null) {
            $data = $this->dis;
        }
        if(property_exists($this, 'module')) {
            return view($this->module . '::' . $viewName, $data);
        }
        return view($viewName, $data);
    }
}
