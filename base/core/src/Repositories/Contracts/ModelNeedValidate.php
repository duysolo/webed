<?php namespace WebEd\Base\Core\Repositories\Contracts;

interface ModelNeedValidate
{
    /**
     * @return mixed
     */
    public function getModelRules();

    /**
     * @param array $rules
     * @return mixed
     */
    public function setModelRules(array $rules);

    /**
     * @param array $rules
     * @return mixed
     */
    public function expandModelRules(array $rules);

}
