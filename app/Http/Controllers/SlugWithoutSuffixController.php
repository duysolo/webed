<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use WebEd\Plugins\Pages\Repositories\Contracts\PageContract;
use WebEd\Plugins\Pages\Repositories\PageRepository;

class SlugWithoutSuffixController extends Controller
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
        $this->repository = $repository;

        $this->pageController = $controller;
    }

    public function handle($slug = null)
    {
        if(!$slug) {
            $page = $this->repository
                ->where('id', '=', get_settings('default_homepage'))
                ->where('status', '=', 'activated')
                ->first();
        } else {
            $page = $this->repository
                ->where('slug', '=', $slug)
                ->where('status', '=', 'activated')
                ->first();
        }

        if(!$page) {
            echo 'You need to setup your default homepage. Go through to Dashboard -> Configuration -> Settings';
            die();
        }

        return $this->pageController->handle($page);
    }
}
