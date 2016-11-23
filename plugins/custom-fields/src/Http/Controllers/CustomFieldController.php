<?php namespace WebEd\Plugins\CustomFields\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;

use WebEd\Base\Core\Support\DataTable\DataTables;
use WebEd\Plugins\CustomFields\Repositories\Contracts\FieldGroupContract;
use WebEd\Plugins\CustomFields\Repositories\Contracts\FieldItemContract;

class CustomFieldController extends BaseAdminController
{
    protected $module = 'webed-custom-fields';

    /**
     * @var \WebEd\Plugins\CustomFields\Repositories\FieldGroupRepository
     */
    protected $repository;

    /**
     * @var \WebEd\Plugins\CustomFields\Repositories\FieldItemRepository
     */
    protected $itemRepository;

    public function __construct(FieldGroupContract $fieldGroup, FieldItemContract $fieldItem)
    {
        parent::__construct();

        $this->getDashboardMenu($this->module);

        $this->breadcrumbs->addLink('Custom fields', route('admin::custom-fields.index.get'));

        $this->repository = $fieldGroup;
        $this->itemRepository = $fieldItem;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $this->assets->addJavascripts('jquery-datatables');

        $this->setPageTitle('Custom fields');

        $this->dis['dataTableColumns'] = [
            'headings' => [
                ['name' => 'Title', 'width' => '50%'],
                ['name' => 'Status', 'width' => '10%'],
                ['name' => 'Sort order', 'width' => '10%'],
                ['name' => 'Actions', 'width' => '20%'],
            ],
            'filter' => [
                1 => form()->text('title', '', [
                    'class' => 'form-control form-filter input-sm',
                    'placeholder' => 'Search...'
                ]),
                2 => form()->select('status', [
                    '' => '',
                    'activated' => 'Activated',
                    'disabled' => 'Disabled',
                ], '', ['class' => 'form-control form-filter input-sm'])
            ],
            'tableActions' => form()->select('', [
                '' => 'Select...',
                'deleted' => 'Deleted',
                'activated' => 'Activated',
                'disabled' => 'Disabled',
            ], '', [
                'class' => 'table-group-action-input form-control input-inline input-small input-sm'
            ])
        ];

        $this->dis['dataTableHeadings'] = json_encode([
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'order', 'name' => 'order', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ]);

        return do_filter('custom-fields.index.get', $this)->viewAdmin('index');
    }

    /**
     * @param DataTables $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(DataTables $dataTable)
    {
        $data = $dataTable
            ->of($this->repository)
            ->with($this->groupAction())
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([
                    ['id[]', $item->id]
                ]);
            })
            ->editColumn('status', function ($item) {
                return html()->label($item->status, $item->status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $editLink = route('admin::custom-fields.field-group.edit.get', ['id' => $item->id]);
                $disableLink = route('admin::custom-fields.field-group.update-status.post', ['id' => $item->id, 'status' => 'disabled']);
                $activeLink = route('admin::custom-fields.field-group.update-status.post', ['id' => $item->id, 'status' => 'activated']);
                $deleteLink = route('admin::custom-fields.field-group.delete', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to($editLink, 'Edit', ['class' => 'btn btn-outline green btn-sm']);
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
                $deleteBtn = form()->button('<i class="fa fa-trash"></i>', [
                    'title' => 'Delete this item',
                    'data-ajax' => $deleteLink,
                    'data-method' => 'DELETE',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                ]);

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn;
            });
        return do_filter('datatables.custom-fields.index.post', $data, $this)
            ->make(true);
    }

    /**
     * Handle group actions
     * @return array
     */
    private function groupAction()
    {
        $data = [];
        if ($this->request->get('customActionType', null) == 'group_action') {

            if(!$this->userRepository->hasPermission($this->loggedInUser, 'edit-field-groups')) {
                return [
                    'customActionMessage' => 'You do not have permission',
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$this->request->get('id', []);

            $actionValue = $this->request->get('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if(!$this->userRepository->hasPermission($this->loggedInUser, 'delete-field-groups')) {
                        return [
                            'customActionMessage' => 'You do not have permission',
                            'customActionStatus' => 'danger',
                        ];
                    }
                    /**
                     * Delete pages
                     */
                    $result = $this->repository->delete($ids);
                    break;
                case 'activated':
                case 'diabled':
                    $result = $this->repository->updateMultiple($ids, [
                        'status' => $actionValue,
                    ], true);
                    break;
                default:
                    $result = [
                        'messages' => 'Method not allowed',
                        'error' => true
                    ];
                    break;
            }

            $data['customActionMessage'] = $result['messages'];
            $data['customActionStatus'] = $result['error'] ? 'danger' : 'success';

        }
        return $data;
    }

    public function postUpdateStatus($id, $status)
    {
        $data = [
            'status' => $status
        ];
        $result = $this->repository->updateFieldGroup($id, $data);
        return response()->json($result, $result['response_code']);
    }

    public function getCreate()
    {
        $this->middleware('has-permission:create-field-groups');

        $this->setPageTitle('Create field group');
        $this->breadcrumbs->addLink('Create field group');

        $this->dis['currentId'] = 0;

        $this->dis['customFieldItems'] = json_encode([]);

        $this->dis['object'] = $this->repository->getModel();
        $oldInputs = old();
        if ($oldInputs) {
            foreach ($oldInputs as $key => $row) {
                if($key === 'customFieldItems') {
                    $this->dis['customFieldItems'] = $row;
                } else {
                    $this->dis['object']->$key = $row;
                }
            }
        }

        return do_filter('custom-fields.create.get', $this)->viewAdmin('edit');
    }

    public function getEdit($id)
    {
        $this->middleware('has-permission:edit-field-groups');

        $item = $this->repository->find($id);

        if (!$item) {
            $this->flashMessagesHelper
                ->addMessages('This field group not exists', 'danger')
                ->showMessagesOnSession();

            return redirect()->to(route('admin::custom-fields.field-group.edit.get'));
        }

        $this->setPageTitle('Edit field group', '#' . $id . ' ' . $item->name);
        $this->breadcrumbs->addLink('Edit field group');

        $this->dis['object'] = $item;

        $this->dis['currentId'] = $id;

        $this->dis['customFieldItems'] = json_encode($this->repository->getFieldGroupItems($id));

        return do_filter('custom-fields.edit.get', $this, $id)->viewAdmin('edit');
    }

    public function postEdit($id = null)
    {
        $this->middleware('has-permission:edit-field-groups');

        if (!$id) {
            $result = $this->createFieldGroup();
        } else {
            $result = $this->updateFieldGroup($id);
        }

        $msgType = $result['error'] ? 'danger' : 'success';

        $this->flashMessagesHelper
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            if((int)$id < 1) {
                return redirect()->back()->withInput();
            }
            return redirect()->back();
        }

        do_action('custom-fields.after-edit.post', $id, $result, $this);

        if ($this->request->has('_continue_edit')) {
            if (!$id) {
                return redirect()->to(route('admin::custom-fields.field-group.edit.get', ['id' => $result['data']->id]));
            }
            return redirect()->back();
        }

        return redirect()->to(route('admin::custom-fields.index.get'));
    }

    private function createFieldGroup()
    {
        if(!$this->userRepository->hasPermission($this->loggedInUser, 'create-field-groups')) {
            return redirect()->to(route('admin::error', ['code' => 403]));
        }

        return $this->repository->createFieldGroup(array_merge($this->request->except(['_token']), ['updated_by' => $this->loggedInUser->id]));
    }

    private function updateFieldGroup($id)
    {
        return $this->repository->updateFieldGroup($id, array_merge($this->request->except(['_token']), ['updated_by' => $this->loggedInUser->id]));
    }

    public function deleteDelete($id)
    {
        $result = $this->repository->deleteFieldGroup($id);

        do_action('custom-fields.after-delete.delete', $id, $result, $this);

        return response()->json($result, $result['response_code']);
    }
}
