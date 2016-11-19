<?php namespace WebEd\Base\ACL\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;
use WebEd\Base\ACL\Repositories\Contracts\PermissionContract;
use WebEd\Base\Core\Support\DataTable\DataTables;

class PermissionController extends BaseAdminController
{
    protected $module = 'webed-acl';

    /**
     * @var \WebEd\Base\ACL\Repositories\PermissionRepository
     */
    protected $repository;

    public function __construct(PermissionContract $repository)
    {
        parent::__construct();

        $this->middleware('has-permission:view-permissions');

        $this->repository = $repository;

        $this->getDashboardMenu($this->module . '-permissions');

        $this->breadcrumbs
            ->addLink('ACL');
    }

    public function getIndex()
    {
        $this->assets->addJavascripts('jquery-datatables');

        $this->setPageTitle('Permissions', 'All available permissions');

        $this->breadcrumbs
            ->addLink('Permissions', route('admin::acl-permissions.index.get'));

        $this->dis['dataTableColumns'] = [
            'headings' => [
                ['name' => 'Name', 'width' => '30%'],
                ['name' => 'Module', 'width' => '30%'],
                ['name' => 'Alias', 'width' => '20%'],
            ],
            'filter' => [
                0 => form()->text('slug', '', [
                    'class' => 'form-control form-filter input-sm',
                    'placeholder' => 'Search...'
                ]),
                1 => form()->text('module', '', [
                    'class' => 'form-control form-filter input-sm',
                    'placeholder' => 'Search...'
                ]),
                2 => form()->text('name', '', [
                    'class' => 'form-control form-filter input-sm',
                    'placeholder' => 'Search...'
                ]),
            ]
        ];

        $this->dis['dataTableHeadings'] = json_encode([
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'module', 'name' => 'module'],
            ['data' => 'slug', 'name' => 'slug'],
        ]);

        return do_filter('acl-permissions.index.get', $this)->viewAdmin('index-permissions');
    }

    public function postListing(DataTables $dataTable)
    {
        $data = $dataTable
            ->of($this->repository);
        return do_filter('datatables.acl-permissions.index.post', $data, $this)
            ->make(true);
    }
}
