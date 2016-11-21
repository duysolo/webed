<?php namespace WebEd\Base\ThemesManagement\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;
use WebEd\Base\Core\Support\DataTable\DataTables;

class ThemeController extends BaseAdminController
{
    protected $module = 'webed-themes-management';

    public function __construct()
    {
        parent::__construct();

        $this->middleware('has-permission:view-themes');
    }

    /**
     * Get index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $this->breadcrumbs->addLink('Themes');

        $this->assets->addJavascripts('jquery-datatables');

        $this->setPageTitle('Themes');

        $this->getDashboardMenu($this->module);

        $this->dis['dataTableColumns'] = [
            'headings' => [
                ['name' => 'Thumbnail', 'width' => '1%'],
                ['name' => 'Name', 'width' => '20%'],
                ['name' => 'Description', 'width' => '40%'],
                ['name' => 'Actions', 'width' => '40%'],
            ],
        ];

        $this->dis['dataTableHeadings'] = json_encode([
            ['data' => 'thumbnail', 'name' => 'thumbnail', 'searchable' => false, 'orderable' => false],
            ['data' => 'name', 'name' => 'name', 'searchable' => false, 'orderable' => false],
            ['data' => 'description', 'name' => 'description', 'searchable' => false, 'orderable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ]);

        return do_filter('webed-themes-management.index.get', $this)->viewAdmin('list');
    }

    /**
     * Set data for DataTable plugin
     * @param DataTables $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(DataTables $dataTable)
    {
        $themes = collect(get_all_theme_information());

        $data = $dataTable
            ->of($themes->values())
            ->editColumn('description', function ($item) {
                return array_get($item, 'description') . '<br><br>'
                . 'Author: ' . array_get($item, 'author') . '<br>'
                . 'Version: <b>' . array_get($item, 'version', '...') . '</b>';
            })
            ->addColumn('thumbnail', function ($item) {
                $themeFolder = get_base_folder($item['file']);
                $themeThumbnail = $themeFolder . 'theme.jpg';
                if (!\File::exists($themeThumbnail)) {
                    $themeThumbnail = webed_themes_path('default-thumbnail.jpg');
                }
                $imageData = base64_encode(\File::get($themeThumbnail));
                $src = 'data: ' . mime_content_type($themeThumbnail) . ';base64,' . $imageData;
                return '<img src="' . $src . '" alt="' . array_get($item, 'alias') . '" width="240" height="180" class="theme-thumbnail">';
            })
            ->addColumn('actions', function ($item) {
                $activeBtn = (!array_get($item, 'enabled')) ? form()->button('Active', [
                    'title' => 'Active this theme',
                    'data-ajax' => route('admin::themes.change-status.post', [
                        'module' => array_get($item, 'alias'),
                        'status' => 1,
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                ]) : '';
                $disableBtn = (array_get($item, 'enabled')) ? form()->button('Disable', [
                    'title' => 'Disable this theme',
                    'data-ajax' => route('admin::themes.change-status.post', [
                        'module' => array_get($item, 'alias'),
                        'status' => 0,
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                ]) : '';

                $installBtn = (array_get($item, 'enabled') && !array_get($item, 'installed')) ? form()->button('Install', [
                    'title' => 'Install this theme\'s dependencies',
                    'data-ajax' => route('admin::themes.install.post', [
                        'module' => array_get($item, 'alias'),
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                ]) : '';

                $uninstallBtn = (array_get($item, 'enabled') && array_get($item, 'installed')) ? form()->button('Uninstall', [
                    'title' => 'Uninstall this theme\'s dependencies',
                    'data-ajax' => route('admin::themes.uninstall.post', [
                        'module' => array_get($item, 'alias'),
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                ]) : '';

                return $activeBtn . $disableBtn . $installBtn . $uninstallBtn;
            });

        return do_filter('datatables.webed-themes-management.index.post', $data, $this)
            ->make(true);
    }

    public function postChangeStatus($alias, $status)
    {
        $this->middleware('has-permission:edit-themes');

        switch ((bool)$status) {
            case true:
                return \ThemesManagement::enableTheme($alias)->refreshComposerAutoload();
                break;
            default:
                return \ThemesManagement::disableTheme($alias)->refreshComposerAutoload();
                break;
        }
    }

    public function postInstall($alias)
    {
        $this->middleware('has-permission:edit-themes');

        $module = get_theme_information($alias);

        if (!$module) {
            return response_with_messages('Theme not exists', true, 500);
        }

        \Artisan::call('theme:install', [
            'alias' => $alias
        ]);

        return response_with_messages('Installed theme dependencies');
    }

    public function postUninstall($alias)
    {
        $this->middleware('has-permission:edit-themes');

        $module = get_theme_information($alias);

        if (!$module) {
            return response_with_messages('Theme not exists', true, 500);
        }

        \Artisan::call('theme:uninstall', [
            'alias' => $alias
        ]);

        return response_with_messages('Uninstalled theme dependencies');
    }
}
