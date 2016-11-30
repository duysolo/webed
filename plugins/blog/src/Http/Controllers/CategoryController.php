<?php namespace WebEd\Plugins\Blog\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;
use WebEd\Base\Core\Support\DataTable\DataTables;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

class CategoryController extends BaseAdminController
{
    protected $module = 'webed-blog';

    /**
     * CategoryController constructor.
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->breadcrumbs->addLink('Blog')
            ->addLink('Categories', route('admin::blog.categories.index.get'));

        $this->getDashboardMenu('webed-blog-categories');
    }

    public function getIndex()
    {
        $this->assets->addJavascripts('jquery-datatables');

        $this->setPageTitle('Categories', 'All available blog categories');

        $this->dis['dataTableColumns'] = [
            'headings' => [
                ['name' => 'Title', 'width' => '35%'],
                ['name' => 'Page template', 'width' => '15%'],
                ['name' => 'Status', 'width' => '10%'],
                ['name' => 'Order', 'width' => '5%'],
                ['name' => 'Created at', 'width' => '10%'],
                ['name' => 'Actions', 'width' => '15%'],
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
            ['data' => 'title', 'name' => 'title', 'searchable' => false, 'orderable' => false],
            ['data' => 'page_template', 'name' => 'page_template', 'searchable' => false, 'orderable' => false],
            ['data' => 'status', 'name' => 'status', 'searchable' => false, 'orderable' => false],
            ['data' => 'order', 'name' => 'order', 'searchable' => false, 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false, 'orderable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ]);

        return do_filter('blog.categories.index.get', $this)->viewAdmin('index-categories');
    }

    /**
     * Get data for DataTable
     * @param DataTables $dataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(DataTables $dataTable)
    {
        $allCategories = get_categories();
        $categories = collect(collect_all_categories_to_one_array(categories_with_indent_text($allCategories)));

        $data = $dataTable
            ->of($categories)
            ->with($this->groupAction())
            ->editColumn('id', function ($item) {
                return \Form::customCheckbox(['id[]' => [$item->id]]);
            })
            ->editColumn('title', function ($item) {
                return $item->indent_text . $item->title;
            })
            ->editColumn('status', function ($item) {
                return \Html::label($item->status, $item->status);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::blog.categories.update-status.post', ['id' => $item->id, 'status' => 'activated']);
                $disableLink = route('admin::blog.categories.update-status.post', ['id' => $item->id, 'status' => 'disabled']);
                $deleteLink = route('admin::blog.categories.delete.delete', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::blog.categories.edit.get', ['id' => $item->id]), 'Edit', ['class' => 'btn btn-sm btn-outline green']);
                $activeBtn = ($item->status != 'activated') ? \Form::button('Active', [
                    'title' => 'Active this item',
                    'data-ajax' => $activeLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';
                $disableBtn = ($item->status != 'disabled') ? \Form::button('Disable', [
                    'title' => 'Disable this item',
                    'data-ajax' => $disableLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                    'type' => 'button',
                ]) : '';
                $deleteBtn = \Form::button('Delete', [
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
            if(!$this->userRepository->hasPermission($this->loggedInUser, 'edit-categories')) {
                return [
                    'customActionMessage' => 'You do not have permission',
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$this->request->get('id', []);
            $actionValue = $this->request->get('customActionValue');

            switch ($actionValue) {
                case 'deleted':
                    if(!$this->userRepository->hasPermission($this->loggedInUser, 'delete-categories')) {
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
        $result = $this->repository->updatePost($id, $data);
        return response()->json($result, $result['response_code']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        $allCategories = get_categories();
        $categories = collect_all_categories_to_one_array(categories_with_indent_text($allCategories));

        $selectArr = [];
        foreach ($categories as $category) {
            $selectArr[$category->id] = $category->indent_text . $category->title;
        }
        $this->dis['categories'] = $selectArr;

        $this->assets
            ->addJavascripts([
                'jquery-ckeditor'
            ]);

        $this->setPageTitle('Create category');
        $this->breadcrumbs->addLink('Create category');

        $this->dis['object'] = $this->repository->getModel();

        $this->dis['currentId'] = 0;

        $oldInputs = old();
        if ($oldInputs) {
            foreach ($oldInputs as $key => $row) {
                $this->dis['object']->$key = $row;
            }
        }

        return do_filter('blog.categories.create.get', $this)->viewAdmin('edit-categories');
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
                ->addMessages('This category not exists', 'danger')
                ->showMessagesOnSession();

            return redirect()->back();
        }

        $allCategories = get_categories();
        $categories = collect_all_categories_to_one_array(categories_with_indent_text($allCategories));

        $selectArr = ['' => 'Select...'];
        $childCategories = [$id];
        $childCategories = $this->repository->getAllRelatedChildrenIds($item, $childCategories);
        foreach ($categories as $category) {
            if(!in_array($category->id, $childCategories)) {
                $selectArr[$category->id] = $category->indent_text . $category->title;
            }
        }
        $this->dis['categories'] = $selectArr;

        $this->setPageTitle('Edit category', $item->title);
        $this->breadcrumbs->addLink('Edit category');

        $this->dis['object'] = $item;
        $this->dis['currentId'] = $id;

        return do_filter('blog.categories.edit.get', $this, $id)->viewAdmin('edit-categories');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id = null)
    {
        $parentId = (int)$this->request->get('parent_id') === (int)$id ? null : $this->request->get('parent_id') ?: null;

        $data = [
            'page_template' => $this->request->get('page_template', null),
            'status' => $this->request->get('status'),
            'title' => $this->request->get('title'),
            'slug' => ($this->request->get('slug') ? str_slug($this->request->get('slug')) : str_slug($this->request->get('title'))),
            'keywords' => $this->request->get('keywords'),
            'description' => $this->request->get('description'),
            'content' => $this->request->get('content'),
            'thumbnail' => $this->request->get('thumbnail'),
            'order' => $this->request->get('order'),
            'updated_by' => $this->loggedInUser->id,
            'parent_id' => $parentId,
        ];

        if ((int)$id < 1) {
            $result = $this->createPost($data);
        } else {
            $result = $this->updatePost($id, $data);
        }

        do_action('blog.categories.after-edit.post', $id, $result, $this);

        $msgType = $result['error'] ? 'danger' : 'success';

        $this->flashMessagesHelper
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            if (!$id) {
                return redirect()->back()->withInput();
            }
        }

        if ($this->request->has('_continue_edit')) {
            if (!$id) {
                if (!$result['error']) {
                    return redirect()->to(route('admin::blog.categories.edit.get', ['id' => $result['data']->id]));
                }
            }
            return redirect()->back();
        }

        return redirect()->to(route('admin::blog.categories.index.get'));
    }

    /**
     * @param array $data
     * @return array
     */
    private function createPost(array $data)
    {
        if(!$this->userRepository->hasPermission($this->loggedInUser, 'create-categories')) {
            return redirect()->to(route('admin::error', ['code' => 403]));
        }

        $data['created_by'] = $this->loggedInUser->id;

        return $this->repository->createCategory($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return array
     */
    private function updatePost($id, array $data)
    {
        return $this->repository->updateCategory($id, $data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDelete($id)
    {
        $result = $this->repository->delete($id);

        do_action('blog.categories.after-delete.delete', $id, $result, $this);

        return response()->json($result, $result['response_code']);
    }
}
