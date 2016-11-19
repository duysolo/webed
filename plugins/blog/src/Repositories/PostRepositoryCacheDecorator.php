<?php namespace WebEd\Plugins\Blog\Repositories;

use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;

use WebEd\Plugins\Blog\Models\Contracts\PostModelContract;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;

class PostRepositoryCacheDecorator extends AbstractRepositoryCacheDecorator  implements PostRepositoryContract
{
    /**
     * @param array $data
     * @return array
     */
    public function createPost($data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param $data
     * @param bool $allowCreateNew
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function updatePost($id, $data, $allowCreateNew = false, $justUpdateSomeFields = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param PostModelContract $model
     * @param array $categories
     */
    public function syncCategories($model, $categories = null)
    {
        $result = call_user_func_array([$this->getRepository(), __FUNCTION__], func_get_args());

        if (is_array($result) && isset($result['error']) && !$result['error']) {
            $this->getCacheInstance()->flushCache();

            /**
             * @var CategoryRepositoryCacheDecorator $categoryRepository
             */
            $categoryRepository = app(CategoryRepositoryContract::class);
            $categoryRepository->getCacheInstance()->flushCache();
        }
        return $result;
    }

    /**
     * @param array $categoryIds
     * @return $this
     */
    public function whereBelongsToCategories(array $categoryIds)
    {
        call_user_func_array([$this->getRepository(), __FUNCTION__], func_get_args());
        return $this;
    }
}
