<?php namespace WebEd\Plugins\CustomFields\Hook\Actions;

use WebEd\Base\AssetsManagement\Assets;

class AssetsInjection
{

    /**
     * @var string
     */
    protected $currentRouteName;

    protected $allowedRoute = [
        'admin::pages.create.get',
        'admin::pages.edit.get',

        /**
         * Blog
         */
        'admin::blog.posts.create.get',
        'admin::blog.posts.edit.get',
        'admin::blog.categories.create.get',
        'admin::blog.categories.edit.get',
    ];

    /**
     * @var Assets;
     */
    protected $assets;

    public function __construct()
    {
        $this->currentRouteName = \Route::currentRouteName();

        $this->assets = \WebEd\Base\AssetsManagement\Facades\Assets::getFacadeRoot();
    }

    public function checkAllowedRoute()
    {
        if (in_array($this->currentRouteName, $this->allowedRoute)) {
            return true;
        }
        return false;
    }

    /**
     * Render js
     */
    public function renderJs()
    {
        if (!$this->checkAllowedRoute()) {
            return;
        }

        if (!$this->assets->assetLoaded('jquery-ckeditor', 'js')) {
            echo '<script type="text/javascript" src="' . asset('admin/plugins/ckeditor/ckeditor.js') . '"></script>';
            echo '<script type="text/javascript" src="' . asset('admin/plugins/ckeditor/config.js') . '"></script>';
            echo '<script type="text/javascript" src="' . asset('admin/plugins/ckeditor/adapters/jquery.js') . '"></script>';
        }

        echo view('webed-custom-fields::admin._script-templates.render-custom-fields')->render();
    }
}
