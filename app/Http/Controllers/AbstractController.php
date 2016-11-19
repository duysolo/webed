<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use WebEd\Base\Core\Http\Controllers\BaseController;

abstract class AbstractController extends BaseController
{
    /**
     * @var mixed|Controller|BaseController
     */
    protected $themeController;

    /**
     * @var string
     */
    protected $currentThemeName;

    public function __construct()
    {
        parent::__construct();

        $currentThemeName = \ThemesManagement::getCurrentTheme();
        if($currentThemeName) {
            $this->currentThemeName = 'webed-theme-' . array_get($currentThemeName, 'alias');
        }
    }

    /**
     * @param $type
     * @param $relatedId
     * @return null|string|mixed
     */
    protected function getMenu($type, $relatedId)
    {
        $menuHtml = webed_menu_render(get_settings('top_menu', 'top-menu'), [
            'class' => 'nav navbar-nav navbar-right',
            'container_class' => 'collapse navbar-collapse',
            'has_sub_class' => 'dropdown',
            'menu_active' => [
                'type' => $type,
                'related_id' => $relatedId,
            ]
        ]);
        view()->share([
            'cmsMenuHtml' => $menuHtml
        ]);
        return $menuHtml;
    }

    /**
     * Override method view of AbstractBase.
     * By now, we will get assets from theme if it exists.
     * @param $viewName
     * @param null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($viewName, $data = null)
    {
        if ($data === null) {
            $data = $this->dis;
        }
        if(view()->exists($this->currentThemeName . '::' . $viewName)) {
            return view($this->currentThemeName . '::' . $viewName, $data);
        }
        return view($viewName, $data);
    }
}
