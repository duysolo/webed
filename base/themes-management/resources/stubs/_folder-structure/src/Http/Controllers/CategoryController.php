<?php namespace DummyNamespace\Http\Controllers;

use WebEd\Plugins\Blog\Models\Category;
use WebEd\Plugins\Blog\Models\Contracts\CategoryModelContract;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

class CategoryController extends AbstractController
{
    protected $module = 'DummyAlias';

    public function __construct(CategoryRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @param Category $item
     * @param array $data
     * @return mixed
     */
    public function handle(CategoryModelContract $item, array $data)
    {
        $this->dis = $data;

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
}
