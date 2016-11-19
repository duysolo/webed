<?php namespace WebEd\Themes\CleanBlog\Http\Controllers;

use App\Http\Controllers\AbstractController;
use WebEd\Plugins\Blog\Models\Contracts\PostModelContract;
use WebEd\Plugins\Blog\Models\Post;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class PostController extends AbstractController
{
    protected $module = 'clean-blog';

    /**
     * @param PostRepository $repository
     */
    public function __construct(PostRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @param Post $item
     * @return mixed
     */
    public function handle(PostModelContract $item, array $data)
    {
        $this->dis = $data;

        $happyMethod = '_template_' . studly_case($item->page_template);
        if(method_exists($this, $happyMethod)) {
            return $this->$happyMethod($item);
        }
        return $this->defaultTemplate($item);
    }

    /**
     * @param Post $item
     * @return mixed
     */
    protected function defaultTemplate(PostModelContract $item)
    {
        $this->dis['relatedPosts'] = $this->repository
            ->whereBelongsToCategories($this->dis['categoryIds'])
            ->where('posts.id', 'NOT_IN', $item->id)
            ->orderByRandom()
            ->take(4)
            ->get();

        return $this->view('front.post-templates.default');
    }
}
