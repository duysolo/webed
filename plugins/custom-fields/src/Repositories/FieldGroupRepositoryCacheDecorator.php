<?php namespace WebEd\Plugins\CustomFields\Repositories;

use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;
use WebEd\Plugins\CustomFields\Repositories\Contracts\FieldGroupContract;

class FieldGroupRepositoryCacheDecorator extends AbstractRepositoryCacheDecorator implements FieldGroupContract
{
    public function getGroupItems($groupId, $parentId = null)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    public function getFieldGroupItems($groupId, $parentId = null, $withValue = false, $morphClass = null, $morphId = null)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $data
     * @param bool $withEvent
     * @return array
     */
    public function createFieldGroup(array $data, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $id
     * @param array $data
     * @param bool $withEvent
     * @return array
     */
    public function updateFieldGroup($id, array $data, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|array $id
     * @param bool $withEvent
     * @return mixed
     */
    public function deleteFieldGroup($id, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
