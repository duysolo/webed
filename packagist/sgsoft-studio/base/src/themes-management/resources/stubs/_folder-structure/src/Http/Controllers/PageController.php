<?php namespace DummyNamespace\Http\Controllers;

use WebEd\Plugins\Pages\Models\Contracts\PageModelContract;
use WebEd\Plugins\Pages\Models\EloquentPage;
use WebEd\Plugins\Pages\Repositories\Contracts\PageContract;
use WebEd\Plugins\Pages\Repositories\PageRepository;

class PageController extends AbstractController
{
    protected $module = 'DummyAlias';

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
}
