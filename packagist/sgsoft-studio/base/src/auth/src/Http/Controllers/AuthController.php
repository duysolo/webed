<?php namespace WebEd\Base\Auth\Http\Controllers;

use WebEd\Base\Auth\Http\Requests\AuthRequest;
use WebEd\Base\Auth\Support\Traits\Auth;

use WebEd\Base\Core\Http\Controllers\BaseController;
use WebEd\Base\Users\Repositories\Contracts\UserContract;

class AuthController extends BaseController
{
    use Auth;

    /**
     * @var string
     */
    protected $module = 'webed-auth';

    /**
     * @var string
     */
    public $username = 'username';

    /**
     * @var string
     */
    public $loginPath = 'auth';

    /**
     * @var string
     */
    public $redirectTo;

    /**
     * @var string
     */
    public $redirectPath;

    /**
     * @var string
     */
    public $redirectToLoginPage;

    /**
     * @var \WebEd\Base\AssetsManagement\Assets
     */
    protected $assets;

    /**
     * AuthController constructor.
     * @param \WebEd\Base\Users\Repositories\UserRepository $userRepository
     */
    public function __construct(UserContract $userRepository)
    {
        $this->middleware('webed.guest-admin', ['except' => ['getLogout']]);

        parent::__construct();

        $this->repository = $userRepository;

        $this->redirectTo = route('admin::dashboard.index.get');
        $this->redirectPath = route('admin::dashboard.index.get');
        $this->redirectToLoginPage = route('admin::auth.login.get');

        $this->assets = \Assets::getAssetsFrom('admin');

        $this->assets
            ->addStylesheetsDirectly([
                asset('admin/theme/lte/css/AdminLTE.min.css'),
                asset('admin/theme/lte/css/skins/skin-purple.min.css'),
                asset('admin/css/style.css'),
            ])
            ->addJavascriptsDirectly([
                asset('admin/theme/lte/js/app.min.js'),
                asset('admin/js/webed-core.js'),
                asset('admin/js/script.js'),
            ], 'bottom');
    }

    /**
     * Show login page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        $this->setBodyClass('login-page');
        $this->setPageTitle('Login');

        return $this->view('admin.login');
    }

    /**
     * @param AuthRequest $authRequest
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function postLogin(AuthRequest $authRequest)
    {
        //Finish validate request

        return $this->login($this->request);
    }

    /**
     * Logout and redirect to login page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->guard()->logout();

        session()->flush();

        session()->regenerate();

        return redirect()->to($this->redirectToLoginPage);
    }
}
