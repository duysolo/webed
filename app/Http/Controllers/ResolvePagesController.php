<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use WebEd\Base\Pages\Repositories\Contracts\PageContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class ResolvePagesController extends AbstractController
{
    /**
     * @var Resolvers\PageController
     */
    protected $pageController;

    /**
     * @var PageContract|PageRepository
     */
    protected $repository;

    /**
     * SlugWithoutSuffixController constructor.
     * @param PageRepository $repository
     */
    public function __construct(PageContract $repository, Resolvers\PageController $controller)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->pageController = $controller;
    }

    public function handle($slug = null)
    {
        if(!$slug) {
            $page = $this->repository
                ->where('id', '=', do_filter('front.default-homepage.get', get_settings('default_homepage')))
                ->where('status', '=', 'activated')
                ->first();
        } else {
            $page = $this->repository
                ->where('slug', '=', $slug)
                ->where('status', '=', 'activated')
                ->first();
        }

        if(!$page) {
            if ($slug === null) {
                echo '<h2>You need to setup your default homepage. Create a page then go through to Admin Dashboard -> Configuration -> Settings</h2>';
                die();
            } else {
                abort(404);
            }
        }

        $page = do_filter('front.resolve-pages.get', $page);

        \AdminBar::registerLink('Edit this page', route('admin::pages.edit.get', ['id' => $page->id]));

        return $this->pageController->handle($page);
    }
}
