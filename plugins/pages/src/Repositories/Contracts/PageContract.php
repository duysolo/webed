<?php namespace WebEd\Plugins\Pages\Repositories\Contracts;

interface PageContract
{
    /**
     * @param $data
     * @return array
     */
    public function createPage($data);

    /**
     * @param $id
     * @param $data
     * @return array
     */
    public function updatePage($id, $data);

    /**
     * @param int|array $id
     * @return mixed
     */
    public function deletePage($id);
}
