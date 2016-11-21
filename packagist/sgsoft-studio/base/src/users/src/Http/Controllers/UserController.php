<?php namespace WebEd\Base\Users\Http\Controllers;

use WebEd\Base\ACL\Repositories\Contracts\RoleContract;
use WebEd\Base\Core\Http\Controllers\BaseAdminController;
use WebEd\Base\Core\Support\DataTable\DataTables;
use WebEd\Base\Users\Http\Requests\AssignRolesRequest;
use WebEd\Base\Users\Repositories\Contracts\UserContract;

class UserController extends BaseAdminController
{
    protected $module = 'webed-users';

    /**
     * @var \WebEd\Base\Users\Repositories\UserRepository
     */
    protected $repository;

    public function __construct(UserContract $userRepository)
    {
        parent::__construct();

        $this->repository = $userRepository;
        $this->breadcrumbs->addLink('Users', route('admin::users.index.get'));

        $this->getDashboardMenu($this->module);
    }

    public function getIndex()
    {
        $this->middleware('has-permission:view-users');

        $this->assets->addJavascripts('jquery-datatables');

        $this->setPageTitle('All users');

        $this->dis['dataTableColumns'] = [
            'headings' => [
                ['name' => 'Avatar', 'width' => '1%'],
                ['name' => 'Username', 'width' => '15%'],
                ['name' => 'Email', 'width' => '15%'],
                ['name' => 'Status', 'width' => '5%'],
                ['name' => 'Created at', 'width' => '5%'],
                ['name' => 'Roles', 'width' => '10%'],
                ['name' => 'Actions', 'width' => '10%']
            ],
            'filter' => [
                2 => form()->text('username', '', [
                    'class' => 'form-control form-filter input-sm',
                    'placeholder' => 'Search...'
                ]),
                3 => form()->email('email', '', [
                    'class' => 'form-control form-filter input-sm',
                    'placeholder' => 'Search...'
                ]),
                4 => form()->select('status', [
                    '' => '',
                    'activated' => 'Activated',
                    'disabled' => 'Disabled',
                    'deleted' => 'Deleted',
                ], '', ['class' => 'form-control form-filter input-sm'])
            ],
            'tableActions' => form()->select('', [
                '' => 'Select...',
                'activated' => 'Activated',
                'disabled' => 'Disabled',
                'deleted' => 'Deleted',
            ], '', [
                'class' => 'table-group-action-input form-control input-inline input-small input-sm'
            ])
        ];

        $this->dis['dataTableHeadings'] = json_encode([
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'avatar', 'name' => 'avatar', 'searchable' => false, 'orderable' => false],
            ['data' => 'username', 'name' => 'username'],
            ['data' => 'email', 'name' => 'email'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'roles', 'name' => 'roles', 'searchable' => false, 'orderable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ]);

        return do_filter('users.index.get', $this)->viewAdmin('index');
    }

    /**
     * Get data for DataTable
     * @param DataTables $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(DataTables $dataTable)
    {
        $this->middleware('has-permission:view-users');

        $data = $dataTable
            ->of($this->repository)
            ->with($this->groupAction())
            ->editColumn('avatar', function ($item) {
                return '<img src="' . get_image($item->resolved_avatar, '/admin/images/no-avatar-' . $item->sex . '.jpg') . '" width="50" height="50">';
            })
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([['id[]', $item->id]]);
            })
            ->editColumn('status', function ($item) {
                return html()->label($item->status, $item->status);
            })
            ->addColumn('roles', function ($item) {
                $result = [];
                $roles = $this->repository->getRoles($item);
                if ($roles) {
                    foreach ($roles as $key => $row) {
                        $result[] = $row->name;
                    }
                }
                return implode(', ', $result);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::users.update-status.post', ['id' => $item->id, 'status' => 'activated']);
                $disableLink = route('admin::users.update-status.post', ['id' => $item->id, 'status' => 'disabled']);
                $deleteLink = route('admin::users.update-status.post', ['id' => $item->id, 'status' => 'deleted']);

                /*Buttons*/
                $editBtn = link_to(route('admin::users.edit.get', ['id' => $item->id]), 'Edit', ['class' => 'btn btn-outline green btn-sm']);
                $activeBtn = ($item->status != 'activated') ? form()->button('<i class="fa fa-check"></i>', [
                    'title' => 'Active this item',
                    'data-ajax' => $activeLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                ]) : '';
                $disableBtn = ($item->status != 'disabled') ? form()->button('<i class="fa fa-times"></i>', [
                    'title' => 'Disable this item',
                    'data-ajax' => $disableLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                ]) : '';
                $deleteBtn = ($item->status != 'deleted') ? form()->button('<i class="fa fa-trash"></i>', [
                    'title' => 'Delete this item',
                    'data-ajax' => $deleteLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                ]) : '';

                $activeBtn = ($item->status != 'activated') ? $activeBtn : '';
                $disableBtn = ($item->status != 'disabled') ? $disableBtn : '';
                $deleteBtn = ($item->status != 'deleted') ? $deleteBtn : '';

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn;
            });

        return do_filter('datatables.users.index.post', $data, $this)
            ->make(true);
    }

    /**
     * Handle group actions
     * @return array
     */
    private function groupAction()
    {
        $this->middleware('has-permission:edit-other-users');

        $data = [];
        if ($this->request->get('customActionType', null) == 'group_action') {
            $ids = collect($this->request->get('id', []))->filter(function ($value, $index) {
                return (int)$value !== (int)$this->loggedInUser->id;
            })->toArray();

            $actionValue = $this->request->get('customActionValue', 'activated');

            $result = $this->repository->updateMultiple($ids, [
                'status' => $actionValue,
            ], true);

            $data['customActionMessage'] = $result['messages'];
            $data['customActionStatus'] = $result['error'] ? 'danger' : 'success';
        }
        return $data;
    }

    /**
     * Update page status
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus($id, $status)
    {
        $this->middleware('has-permission:edit-other-users');

        $data = [
            'status' => $status
        ];

        if (auth()->user()->id == $id) {
            $result = $this->repository->setMessages('You cannot update status of yourself', true, 500);
        } else {
            $result = $this->repository->updateUser($id, $data);
        }
        return response()->json($result, $result['response_code']);
    }

    /**
     * @param \WebEd\Base\ACL\Repositories\RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate(RoleContract $roleRepository)
    {
        $this->middleware('has-permission:create-user');

        $this->setPageTitle('Create user');
        $this->breadcrumbs->addLink('Create user');

        $this->dis['isLoggedInUser'] = false;
        $this->dis['isSuperAdmin'] = $this->loggedInUser->isSuperAdmin();

        $this->dis['currentId'] = 0;

        $this->dis['object'] = $this->repository->getModel();

        $oldInputs = old();
        if ($oldInputs) {
            foreach ($oldInputs as $key => $row) {
                $this->dis['object']->$key = $row;
            }
        }

        $this->assets
            ->addStylesheets('bootstrap-datepicker')
            ->addJavascripts('bootstrap-datepicker')
            ->addJavascriptsDirectly(asset('admin/pages/user-profiles/user-profiles.js'))
            ->addStylesheetsDirectly(asset('admin/pages/user-profiles/user-profiles.css'));

        return do_filter('users.create.get', $this)->viewAdmin('create');
    }

    /**
     * @param \WebEd\Base\ACL\Repositories\RoleRepository $roleRepository
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit(RoleContract $roleRepository, $id)
    {
        $this->dis['isLoggedInUser'] = (int)$this->loggedInUser->id === (int)$id ? true : false;
        $this->dis['isSuperAdmin'] = $this->loggedInUser->isSuperAdmin();

        if ((int)$this->loggedInUser->id !== (int)$id) {
            $this->middleware('has-permission:edit-other-users');
        }

        $item = $this->repository->find($id);

        if (!$item) {
            $this->flashMessagesHelper
                ->addMessages('User not found', 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $this->setPageTitle('Edit user', '#' . $id);
        $this->breadcrumbs->addLink('Edit user');

        $this->dis['object'] = $item;

        if (!$this->dis['isLoggedInUser'] && ($this->dis['isSuperAdmin'] || $this->loggedInUser->hasPermission('assign-roles'))) {
            $roles = $roleRepository->all();

            $checkedRoles = $item->roles()->getRelatedIds()->toArray();

            $resolvedRoles = [];
            foreach ($roles as $role) {
                $resolvedRoles[] = [
                    'roles[]', $role->id, $role->name, (in_array($role->id, $checkedRoles))
                ];
            }
            $this->dis['roles'] = $resolvedRoles;
        }

        $this->dis['currentId'] = $id;

        $this->assets
            ->addStylesheets('bootstrap-datepicker')
            ->addJavascripts('bootstrap-datepicker')
            ->addJavascriptsDirectly(asset('admin/pages/user-profiles/user-profiles.js'))
            ->addStylesheetsDirectly(asset('admin/pages/user-profiles/user-profiles.css'));

        return do_filter('users.edit.get', $this, $id)->viewAdmin('edit');
    }

    /**
     * Create/Edit page
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(AssignRolesRequest $assignRolesRequest, $id)
    {
        if ((int)$this->loggedInUser->id !== (int)$id) {
            $this->middleware('has-permission:edit-other-users');
        }
        if ($this->request->exists('roles')) {
            $this->middleware('has-role:assign-roles');
        }

        $data = [];
        if ($assignRolesRequest->requestHasRoles()) {
            $data['roles'] = $assignRolesRequest->getResolvedRoles();
        } else {
            if ($this->request->get('_tab') === 'roles') {
                $data['roles'] = [];
            }
        }
        if ($this->request->exists('birthday') && !$this->request->get('birthday')) {
            $data['birthday'] = null;
        }

        if (!$id) {
            $result = $this->createUser($data);
        } else {
            $result = $this->updateUser($id, $data);
        }

        $msgType = $result['error'] ? 'danger' : 'success';

        $this->flashMessagesHelper
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            if (!$id) {
                return redirect()->back()->withInput();
            }
        }

        do_action('users.after-edit.post', $id, $result, $this);

        if ($this->request->has('_continue_edit')) {
            if (!$id) {
                return redirect()->to(route('admin::users.edit.get', ['id' => $result['data']->id]));
            }
            return redirect()->back();
        }

        return redirect()->to(route('admin::users.index.get'));
    }

    /**
     * @param array $crossData
     * @return array|mixed
     */
    private function createUser(array $crossData)
    {
        $this->middleware('has-permission:create-user');

        $data = array_merge($this->request->except([
            '_token', '_continue_edit', '_tab', 'roles',
        ]), $crossData);

        $data['created_by'] = $this->loggedInUser->id;
        $data['updated_by'] = $this->loggedInUser->id;

        return $this->repository->createUser($data);
    }

    /**
     * @param $id
     * @param array $crossData
     * @return array|mixed
     */
    private function updateUser($id, array $crossData)
    {
        $data = array_merge($this->request->except([
            '_token', '_continue_edit', '_tab', 'username', 'email', 'roles'
        ]), $crossData);

        /**
         * It's shit if current user can edit their roles
         */
        $isLoggedInUser = (int)$this->loggedInUser->id === (int)$id ? true : false;
        if ($isLoggedInUser) {
            if ($this->request->exists('roles')) {
                unset($data['roles']);
            }
        }

        $data['updated_by'] = $this->loggedInUser->id;

        return $this->repository->updateUser($id, $data);
    }
}
