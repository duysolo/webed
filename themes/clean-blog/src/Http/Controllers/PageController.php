<?php namespace WebEd\Themes\CleanBlog\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseFrontController;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;
use WebEd\Base\Pages\Models\Contracts\PageModelContract;
use WebEd\Base\Pages\Models\EloquentPage;
use WebEd\Base\Pages\Repositories\Contracts\PageContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class PageController extends BaseFrontController
{
    protected $module = 'clean-blog';

    /**
     * @param PageRepository $repository
     */
    public function __construct(PageContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @param EloquentPage $item
     * @param array $data
     */
    public function handle(PageModelContract $item, array $data)
    {
        $this->dis = $data;

        $happyMethod = '_template_' . studly_case($item->page_template);

        if(method_exists($this, $happyMethod)) {
            return $this->$happyMethod($item);
        }

        return $this->defaultTemplate($item);
    }

    /**
     * @param EloquentPage $page
     * @return mixed
     */
    protected function defaultTemplate(PageModelContract $page)
    {
        return $this->view('front.page-templates.default');
    }

    /**
     * @param EloquentPage $page
     * @return mixed
     */
    protected function _template_Homepage(PageModelContract $page)
    {
        if(!interface_exists('WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract')) {
            echo 'This page require blog plugin....';
            die();
        }
        /**
         * @var PostRepository $postRepository
         */
        $postRepository = app(PostRepositoryContract::class);
        $this->dis['posts'] = $postRepository->where('status', '=', 'activated')
            ->paginate(5)
            ->get();

        return $this->view('front.page-templates.homepage');
    }

    /**
     * @param EloquentPage $page
     * @return mixed
     */
    protected function _template_AboutUs(PageModelContract $page)
    {
        return $this->view('front.page-templates.about-us');
    }

    /**
     * @param EloquentPage $page
     * @return mixed
     */
    protected function _template_ContactUs(PageModelContract $page)
    {
        return $this->view('front.page-templates.contact-us');
    }
}
