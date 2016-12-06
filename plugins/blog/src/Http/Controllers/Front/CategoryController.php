<?php namespace WebEd\Plugins\Blog\Http\Controllers\Front;

use WebEd\Base\Core\Http\Controllers\BaseFrontController;
use WebEd\Plugins\Blog\Models\Category;
use WebEd\Plugins\Blog\Models\Contracts\CategoryModelContract;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class CategoryController extends BaseFrontController
{
    /**
     * @var PostRepository
     */
    protected $postRepository;
    /**
     * @param CategoryRepository $repository
     * @param PostRepository $postRepository
     */
    public function __construct(
        CategoryRepositoryContract $repository,
        PostRepositoryContract $postRepository
    )
    {
        parent::__construct();

        $this->themeController = \ThemesManagement::getThemeController('Category');

        $this->repository = $repository;
        $this->postRepository = $postRepository;
    }

    /**
     * @param Category $item
     * @return mixed
     */
    public function handle(CategoryModelContract $item)
    {
        $this->getMenu('category', $item->id);

        $this->setPageTitle($item->title);

        $this->dis['object'] = $item;

        $this->dis['allRelatedCategoryIds'] = array_unique(array_merge($this->repository->getAllRelatedChildrenIds($item), [$item->id]));

        $posts = $this->postRepository
            ->whereBelongsToCategories($this->dis['allRelatedCategoryIds'])
            ->paginate(5)
            ->get();

        $this->dis['posts'] = $posts;

        if($this->themeController) {
            return $this->themeController->handle($item, $this->dis);
        }

        $happyMethod = '_template_' . studly_case($item->page_template);

        if(method_exists($this, $happyMethod)) {
            return $this->$happyMethod($item);
        }
        return $this->defaultTemplate($item);
    }

    /**
     * @param Category $item
     * @return mixed
     */
    protected function defaultTemplate(CategoryModelContract $item)
    {
        return $this->view('front.category-templates.default');
    }

    /**
     * @param Category $item
     * @return mixed
     */
    protected function _template_Blog(CategoryModelContract $item)
    {
        return $this->view('front.category-templates.blog');
    }
}
