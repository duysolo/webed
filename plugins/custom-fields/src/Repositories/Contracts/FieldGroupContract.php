<?php namespace WebEd\Plugins\CustomFields\Repositories\Contracts;

interface FieldGroupContract
{
    /**
     * @param array $data
     * @return array
     */
    public function createFieldGroup(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateFieldGroup($id, array $data);

    /**
     * @param int|array $id
     * @return mixed
     */
    public function deleteFieldGroup($id);
}
