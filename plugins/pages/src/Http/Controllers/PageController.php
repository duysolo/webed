<?php namespace WebEd\Plugins\Pages\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;
use WebEd\Base\Core\Support\DataTable\DataTables;
use WebEd\Plugins\Pages\Http\Requests\UpdatePageRequest;
use WebEd\Plugins\Pages\Repositories\Contracts\PageContract;

class PageController extends BaseAdminController
{
    protected $module = 'webed-pages';

    /**
     * @param \WebEd\Plugins\Pages\Repositories\PageRepository $pageRepository
     */
    public function __construct(PageContract $pageRepository)
    {
        parent::__construct();

        $this->repository = $pageRepository;

        $this->breadcrumbs->addLink('Pages', route('admin::pages.index.get'));

        $this->getDashboardMenu($this->module);
    }

    /**
     * Show index page
     * @method GET
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $this->assets->addJavascripts('jquery-datatables');

        $this->setPageTitle('CMS pages', 'All available cms pages');

        $this->dis['dataTableColumns'] = [
            'headings' => [
                ['name' => 'Title', 'width' => '25%'],
                ['name' => 'Page template', 'width' => '15%'],
                ['name' => 'Status', 'width' => '10%'],
                ['name' => 'Sort order', 'width' => '10%'],
                ['name' => 'Created at', 'width' => '10%'],
                ['name' => 'Actions', 'width' => '20%'],
            ],
            'filter' => [
                1 => form()->text('title', '', [
                    'class' => 'form-control form-filter input-sm',
                    'placeholder' => 'Search...'
                ]),
                2 => form()->text('page_template', '', [
                    'class' => 'form-control form-filter input-sm',
                    'placeholder' => 'Search...'
                ]),
                3 => form()->select('status', [
                    '' => '',
                    'activated' => 'Activated',
                    'disabled' => 'Disabled',
                ], null, ['class' => 'form-control form-filter input-sm'])
            ],
            'tableActions' => form()->select('', [
                '' => 'Select' . '...',
                'deleted' => 'Deleted',
                'activated' => 'Activated',
                'disabled' => 'Disabled',
            ], null, [
                'class' => 'table-group-action-input form-control input-inline input-small input-sm'
            ])
        ];

        $this->dis['dataTableHeadings'] = json_encode([
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'page_template', 'name' => 'page_template'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'order', 'name' => 'order', 'searchable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ]);

        return do_filter('pages.index.get', $this)->viewAdmin('index');
    }

    /**
     * Get data for DataTable
     * @param DataTables $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(DataTables $dataTable)
    {
        $data = $dataTable
            ->of($this->repository)
            ->with($this->groupAction())
            ->editColumn('id', function ($item) {
                return \Form::customCheckbox(['id[]' => [$item->id]]);
            })
            ->editColumn('status', function ($item) {
                return \Html::label($item->status, $item->status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::pages.update-status.post', ['id' => $item->id, 'status' => 'activated']);
                $disableLink = route('admin::pages.update-status.post', ['id' => $item->id, 'status' => 'disabled']);
                $deleteLink = route('admin::pages.delete.delete', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::pages.edit.get', ['id' => $item->id]), 'Edit', ['class' => 'btn btn-sm btn-outline green']);
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

        return do_filter('datatables.pages.index.post', $data, $this)
            ->make(true);
    }

    /**
     * Handle group actions
     * @return array
     */
    private function groupAction()
    {
        $data = [];
        if ($this->request->get('customActionType', null) === 'group_action') {
            if(!$this->userRepository->hasPermission($this->loggedInUser, 'edit-pages')) {
                return [
                    'customActionMessage' => 'You do not have permission',
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$this->request->get('id', []);
            $actionValue = $this->request->get('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if(!$this->userRepository->hasPermission($this->loggedInUser, 'delete-pages')) {
                        return [
                            'customActionMessage' => 'You do not have permission',
                            'customActionStatus' => 'danger',
                        ];
                    }
                    /**
                     * Delete pages
                     */
                    $result = $this->deleteDelete($ids);
                    break;
                case 'activated':
                case 'disabled':
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

    /**
     * Update page status
     * @param $id
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateStatus($id, $status)
    {
        $data = [
            'status' => $status
        ];
        $result = $this->repository->updatePage($id, $data);
        return response()->json($result, $result['response_code']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle('Create page');
        $this->breadcrumbs->addLink('Create page');

        $this->dis['object'] = $this->repository->getModel();
        $this->dis['currentId'] = 0;

        $oldInputs = old();
        if ($oldInputs) {
            foreach ($oldInputs as $key => $row) {
                $this->dis['object']->$key = $row;
            }
        }

        return do_filter('pages.create.get', $this)->viewAdmin('edit');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit($id)
    {
        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $item = $this->repository->find($id);
        if (!$item) {
            $this->flashMessagesHelper
                ->addMessages('This page not exists', 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $this->setPageTitle('Edit page', $item->title);
        $this->breadcrumbs->addLink('Edit page');

        $this->dis['object'] = $item;
        $this->dis['currentId'] = $id;

        return do_filter('pages.edit.get', $this, $id)->viewAdmin('edit');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdatePageRequest $pageRequest, $id = null)
    {
        $data = [
            'page_template' => $this->request->get('page_template', null),
            'status' => $this->request->get('status'),
            'title' => $this->request->get('title'),
            'slug' => ($this->request->get('slug') ? str_slug($this->request->get('slug')) : str_slug($this->request->get('title'))),
            'keywords' => $this->request->get('keywords'),
            'description' => $this->request->get('description'),
            'content' => $this->request->get('content'),
            'thumbnail' => $this->request->get('thumbnail'),
            'updated_by' => $this->loggedInUser->id,
            'order' => $this->request->get('order'),
        ];

        if ((int)$id < 1) {
            $result = $this->createPage($data);
        } else {
            $result = $this->updatePage($id, $data);
        }

        do_action('pages.after-edit.post', $id, $result, $this);

        $msgType = $result['error'] ? 'danger' : 'success';

        $this->flashMessagesHelper
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if($result['error']) {
            if(!$id) {
                return redirect()->back()->withInput();
            }
        }

        if ($this->request->has('_continue_edit')) {
            if (!$id) {
                if (!$result['error']) {
                    return redirect()->to(route('admin::pages.edit.get', ['id' => $result['data']->id]));
                }
            }
            return redirect()->back();
        }

        return redirect()->to(route('admin::pages.index.get'));
    }

    /**
     * @param array $data
     * @return array
     */
    private function createPage(array $data)
    {
        if(!$this->userRepository->hasPermission($this->loggedInUser, 'create-pages')) {
            return redirect()->to(route('admin::error', ['code' => 403]));
        }

        $data['created_by'] = $this->loggedInUser->id;

        return $this->repository->createPage($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return array
     */
    private function updatePage($id, array $data)
    {
        return $this->repository->updatePage($id, $data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDelete($id)
    {
        $result = $this->repository->deletePage($id);

        do_action('pages.after-delete.delete', $id, $result, $this);

        return response()->json($result, $result['response_code']);
    }
}
