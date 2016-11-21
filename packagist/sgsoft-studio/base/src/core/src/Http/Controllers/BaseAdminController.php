<?php namespace WebEd\Base\Core\Http\Controllers;

abstract class BaseAdminController extends BaseController
{
    /**
     * @var \WebEd\Base\Core\Support\Breadcrumbs
     */
    public $breadcrumbs;

    /**
     * @var \WebEd\Base\Users\Models\EloquentUser
     */
    protected $loggedInUser;

    /**
     * @var \WebEd\Base\AssetsManagement\Assets
     */
    public $assets;

    /**
     * @var \WebEd\Base\Core\Services\FlashMessages
     */
    public $flashMessagesHelper;

    public function __construct()
    {
        $this->middleware('webed.auth-admin');

        parent::__construct();

        $this->breadcrumbs = \Breadcrumbs::setBreadcrumbClass('breadcrumb')
            ->setContainerTag('ol')
            ->addLink('WebEd', route('admin::dashboard.index.get'), '<i class="icon-home mr5"></i>');

        $this->middleware(function ($request, $next) {
            $this->loggedInUser = $request->user();
            view()->share([
                'loggedInUser' => $this->loggedInUser
            ]);
            return $next($request);
        });

        $this->assets = \Assets::getAssetsFrom('admin');

        $this->assets
            ->addStylesheetsDirectly([
                asset('admin/theme/lte/css/AdminLTE.min.css'),
                asset('admin/theme/lte/css/skins/_all-skins.min.css'),
                asset('admin/css/style.css'),
            ])
            ->addJavascriptsDirectly([
                asset('admin/theme/lte/js/app.js'),
                asset('admin/js/webed-core.js'),
                asset('admin/theme/lte/js/demo.js'),
                asset('admin/js/script.js'),
            ], 'bottom');

        $this->flashMessagesHelper = \FlashMessages::getFacadeRoot();
    }

    /**
     * @param null $activeId
     */
    protected function getDashboardMenu($activeId = null)
    {
        \DashboardMenu::render($activeId);
    }

    /**
     * Set view
     * @param $view
     * @param array|null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($view, $data = null, $module = null)
    {
        if ($data === null || !is_array($data)) {
            $data = $this->dis;
        }
        if ($module === null) {
            if (property_exists($this, 'module') && $this->module) {
                return view($this->module . '::' . $view, $data);
            }
        }
        return view($view, $data);
    }

    /**
     * Set view admin
     * @param $view
     * @param array|null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function viewAdmin($view, $data = null, $module = null)
    {
        if ($data === null || !is_array($data)) {
            $data = $this->dis;
        }
        if ($module === null) {
            if (property_exists($this, 'module') && $this->module) {
                return view($this->module . '::admin.' . $view, $data);
            }
        }
        return view('admin.' . $view, $data);
    }

    /**
     * Set view front
     * @param $view
     * @param array|null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function viewFront($view, $data = null, $module = null)
    {
        if ($data === null || !is_array($data)) {
            $data = $this->dis;
        }
        if ($module === null) {
            if (property_exists($this, 'module') && $this->module) {
                return view($this->module . '::front.' . $view, $data);
            }
        }
        return view('front.' . $view, $data);
    }
}
