<?php namespace WebEd\Themes\CleanBlog\Http\Controllers;

use App\Http\Controllers\AbstractController;
use WebEd\Plugins\Blog\Models\Category;
use WebEd\Plugins\Blog\Models\Contracts\CategoryModelContract;

class CategoryController extends AbstractController
{
    protected $module = 'clean-blog';

    public function __construct()
    {
        parent::__construct();
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
