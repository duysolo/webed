<?php namespace WebEd\Base\ModulesManagement\Http\Controllers;

use WebEd\Base\Core\Support\DataTable\DataTables;

class CoreModulesController extends BaseModulesController
{
    protected $module = 'webed-modules-management';

    protected $dashboardMenuId = 'webed-core-modules';

    public function __construct()
    {
        parent::__construct();

        $this->middleware('has-permission:view-modules');
    }

    /**
     * Get index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $this->breadcrumbs->addLink('Core modules');

        $this->assets->addJavascripts('jquery-datatables');

        $this->setPageTitle('Core modules');

        $this->getDashboardMenu($this->dashboardMenuId);

        $this->dis['dataTableColumns'] = [
            'headings' => [
                ['name' => 'Name', 'width' => '20%'],
                ['name' => 'Description', 'width' => '80%'],
            ],
        ];

        $this->dis['dataTableHeadings'] = json_encode([
            ['data' => 'name', 'name' => 'name', 'searchable' => false, 'orderable' => false],
            ['data' => 'description', 'name' => 'description', 'searchable' => false, 'orderable' => false],
        ]);

        return do_filter('webed-modules-core.index.get', $this)->viewAdmin('core-list');
    }

    /**
     * Set data for DataTable plugin
     * @param DataTables $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(DataTables $dataTable)
    {
        $modules = \ModulesManagement::export('base');

        $data = $dataTable
            ->of($modules->values())
            ->editColumn('description', function ($item) {
                return array_get($item, 'description') . '<br><br>'
                . 'Author: ' . array_get($item, 'author') . '<br>'
                . 'Version: <b>' . array_get($item, 'version', '...') . '</b>';
            });

        return do_filter('datatables.webed-modules-core.index.post', $data, $this)
            ->make(true);
    }
}
