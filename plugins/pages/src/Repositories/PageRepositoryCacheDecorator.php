<?php namespace WebEd\Plugins\Pages\Repositories;

use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;
use WebEd\Plugins\Pages\Repositories\Contracts\PageContract;

class PageRepositoryCacheDecorator extends AbstractRepositoryCacheDecorator implements PageContract
{
    /**
     * @param $data
     * @param array|null $dataTranslate
     * @return array
     */
    public function createPage($data, $dataTranslate = null)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param $data
     * @param array|null $dataTranslate
     * @return array
     */
    public function updatePage($id, $data, $dataTranslate = null)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|array $id
     * @return array
     */
    public function deletePage($id)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
