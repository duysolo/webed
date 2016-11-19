<?php namespace WebEd\Base\Menu\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;
use WebEd\Base\Core\Support\DataTable\DataTables;
use WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use WebEd\Base\Menu\Repositories\MenuRepository;

class MenuController extends BaseAdminController
{
    protected $module = 'webed-menu';

    /**
     * @param MenuRepository $repository
     */
    public function __construct(MenuRepositoryContract $repository)
    {
        parent::__construct();

        $this->middleware('has-permission:view-menus');

        $this->repository = $repository;

        $this->getDashboardMenu($this->module);

        $this->breadcrumbs->addLink('Menus', 'admin::menus.index.get');
    }

    public function getIndex()
    {
        $this->assets
            ->addJavascripts('jquery-datatables');

        $this->setPageTitle('Menus management');

        $this->dis['dataTableColumns'] = [
            'headings' => [
                ['name' => 'Title', 'width' => '25%'],
                ['name' => 'Alias', 'width' => '25%'],
                ['name' => 'Status', 'width' => '15%'],
                ['name' => 'Created at', 'width' => '15%'],
                ['name' => 'Actions', 'width' => '20%'],
            ],
        ];

        $this->dis['dataTableHeadings'] = json_encode([
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'slug', 'name' => 'alias'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ]);

        return do_filter('menus.index.get', $this)->viewAdmin('list');
    }

    public function postListing(DataTables $dataTable)
    {
        $data = $dataTable
            ->of($this->repository)
            ->editColumn('status', function ($item) {
                return \Html::label($item->status, $item->status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::menus.update-status.post', ['id' => $item->id, 'status' => 'activated']);
                $disableLink = route('admin::menus.update-status.post', ['id' => $item->id, 'status' => 'disabled']);
                $deleteLink = route('admin::menus.delete.delete', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::menus.edit.get', ['id' => $item->id]), 'Edit', ['class' => 'btn btn-sm btn-outline green']);

                $activeBtn = ($item->status != 'activated') ? \Form::button('<i class="fa fa-check"></i>', [
                    'title' => 'Active this item',
                    'data-ajax' => $activeLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';

                $disableBtn = ($item->status != 'disabled') ? \Form::button('<i class="fa fa-times"></i>', [
                    'title' => 'Disable this item',
                    'data-ajax' => $disableLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';

                $deleteBtn = \Form::button('<i class="fa fa-trash"></i>', [
                    'title' => 'Delete this item',
                    'data-ajax' => $deleteLink,
                    'data-method' => 'DELETE',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    'type' => 'button',
                ]);

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn;
            });

        return do_filter('datatables.menu.index.post', $data, $this)
            ->make(true);
    }

    /**
     * Update page status
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus($id, $status)
    {
        $this->middleware('has-permission:edit-menus');

        $data = [
            'status' => $status
        ];
        $result = $this->repository->editWithValidate($id, $data, false, true);

        return response()->json($result, $result['response_code']);
    }

    /**
     * Go to create menu page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        $this->middleware('has-permission:create-menus');

        $this->assets
            ->addStylesheets('jquery-nestable')
            ->addStylesheetsDirectly(asset('admin/modules/menu/menu-nestable.css'))
            ->addJavascripts('jquery-nestable')
            ->addJavascriptsDirectly(asset('admin/modules/menu/edit-menu.js'));

        $this->setPageTitle('Create menu');
        $this->breadcrumbs->addLink('Create menu');

        $this->dis['currentId'] = 0;

        $this->dis['object'] = $this->repository->getModel();
        $oldInputs = old();
        if ($oldInputs) {
            foreach ($oldInputs as $key => $row) {
                if($key === 'menu_structure') {
                    $this->dis['menuStructure'] = $row;
                } else {
                    $this->dis['object']->$key = $row;
                }
            }
        }

        return do_filter('menus.create.get', $this)->viewAdmin('edit');
    }

    /**
     * Go to edit menu page
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $this->middleware('has-permission:edit-menus');

        $this->assets
            ->addStylesheets('jquery-nestable')
            ->addStylesheetsDirectly(asset('admin/modules/menu/menu-nestable.css'))
            ->addJavascripts('jquery-nestable')
            ->addJavascriptsDirectly(asset('admin/modules/menu/edit-menu.js'));

        $item = $this->repository->getMenu($id);
        if (!$item) {
            $this->flashMessagesHelper
                ->addMessages('This menu not exists', 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $this->setPageTitle('Edit menu', $item->title);
        $this->breadcrumbs->addLink('Edit menu');

        $this->dis['menuStructure'] = json_encode($item->all_menu_nodes);

        $this->dis['object'] = $item;
        $this->dis['currentId'] = $id;

        return do_filter('menus.edit.get', $this, $id)->viewAdmin('edit');
    }

    /**
     * Handle edit menu
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id = null)
    {
        $data = [
            'menu_structure' => $this->request->get('menu_structure'),
            'deleted_nodes' => $this->request->get('deleted_nodes'),
            'status' => $this->request->get('status'),
            'title' => $this->request->get('title'),
            'slug' => ($this->request->get('slug') ? str_slug($this->request->get('slug')) : str_slug($this->request->get('title'))),
            'updated_by' => $this->loggedInUser->id,
        ];

        if((int)$id < 1) {
            $this->middleware('has-permission:create-menus');

            $result = $this->repository->createMenu($data);
        } else {
            $result = $this->repository->updateMenu($id, $data);
        }

        $msgType = $result['error'] ? 'danger' : 'success';

        $this->flashMessagesHelper
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if($result['error']) {
            if((int)$id < 1) {
                return redirect()->back()->withInput();
            }
            return redirect()->back();
        }

        do_action('menus.after-edit.post', $id, $result, $this);

        if ($this->request->has('_continue_edit')) {
            if (!(int)$id) {
                if (!$result['error']) {
                    return redirect()->to(route('admin::menus.edit.get', ['id' => $result['data']->id]));
                }
            }
            return redirect()->back();
        }

        return redirect()->to(route('admin::menus.index.get'));
    }

    /**
     * Delete menu
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDelete($id)
    {
        $this->middleware('has-permission:delete-menus');

        $result = $this->repository->delete($id);

        do_action('menus.after-delete.delete', $id, $result);

        return response()->json($result, $result['response_code']);
    }
}
