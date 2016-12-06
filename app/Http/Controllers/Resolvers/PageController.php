<?php namespace App\Http\Controllers\Resolvers;

use WebEd\Base\Core\Http\Controllers\BaseFrontController;
use WebEd\Base\Pages\Models\Contracts\PageModelContract;
use WebEd\Base\Pages\Models\EloquentPage;
use WebEd\Base\Pages\Repositories\Contracts\PageContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class PageController extends BaseFrontController
{
    /**
     * @param PageRepository $repository
     */
    public function __construct(PageContract $repository)
    {
        parent::__construct();

        $this->themeController = \ThemesManagement::getThemeController('Page');

        $this->repository = $repository;
    }

    /**
     * @param EloquentPage $item
     * @return mixed
     */
    public function handle(PageModelContract $item)
    {
        $this->getMenu('page', $item->id);

        $this->setPageTitle($item->title);

        $this->dis['object'] = $item;

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
     * @param EloquentPage $page
     * @return mixed
     */
    protected function defaultTemplate(PageModelContract $page)
    {
        return $this->view('front.page-templates.default');
    }
}
