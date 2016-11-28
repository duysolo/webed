<?php namespace WebEd\Themes\Startr\Http\Controllers;

use WebEd\Base\Pages\Models\Contracts\PageModelContract;
use WebEd\Base\Pages\Models\EloquentPage;
use WebEd\Base\Pages\Repositories\Contracts\PageContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class PageController extends AbstractController
{
    protected $module = 'startr';

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
     * @param PageModelContract $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function _template_LandingPage(PageModelContract $page)
    {
        return $this->view('front.page-templates.landing-page');
    }
}
