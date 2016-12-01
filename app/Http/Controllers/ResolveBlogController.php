<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class ResolveBlogController extends AbstractController
{
    /**
     * @var Resolvers\PageController
     */
    protected $controller;

    /**
     * @var PostRepositoryContract|PostRepository
     */
    protected $repository;

    /**
     * @var Resolvers\CategoryController
     */
    protected $categoryController;

    /**
     * @var PostRepositoryContract|PostRepository
     */
    protected $categoryRepository;

    /**
     * @param PostRepositoryContract|PostRepository $repository
     * @param Resolvers\PostController $controller
     * @param CategoryRepositoryContract|CategoryRepository $categoryRepositoryContract
     * @param Resolvers\CategoryController $CategoryController
     */
    public function __construct(
        PostRepositoryContract $repository,
        Resolvers\PostController $controller,
        CategoryRepositoryContract $categoryRepositoryContract,
        Resolvers\CategoryController $CategoryController
    )
    {
        parent::__construct();

        $this->repository = $repository;
        $this->controller = $controller;

        $this->categoryController = $CategoryController;
        $this->categoryRepository = $categoryRepositoryContract;
    }

    /**
     * First, we will find the post match this slug. If not exists, we will find the category match this slug.
     * @param $slug
     * @return mixed
     */
    public function handle($slug)
    {
        $post = $this->repository
            ->where('slug', '=', $slug)
            ->where('status', '=', 'activated')
            ->first();

        if ($post) {
            $post = do_filter('front.resolve-posts.get', $post);

            \AdminBar::registerLink('Edit this post', route('admin::blog.posts.edit.get', ['id' => $post->id]));

            return $this->controller->handle($post);
        }

        $category = $this->categoryRepository
            ->where('slug', '=', $slug)
            ->where('status', '=', 'activated')
            ->first();

        if($category) {
            $category = do_filter('front.resolve-categories.get', $category);

            \AdminBar::registerLink('Edit this category', route('admin::blog.categories.edit.get', ['id' => $category->id]));

            return $this->categoryController->handle($category);
        }

        return abort(404);
    }
}
