<?php namespace WebEd\Base\Core\Repositories;

use WebEd\Base\Core\Models\Contracts\BaseModelContract;

use WebEd\Base\Core\Repositories\Traits\EloquentBaseMethods as BaseMethods;
use WebEd\Base\Core\Repositories\Traits\RepositoryRules;

use WebEd\Base\Core\Repositories\Contracts\ModelNeedValidate;
use WebEd\Base\Core\Repositories\Contracts\BaseMethodsContract;

use WebEd\Base\Caching\Repositories\Traits\Cacheable;

abstract class AbstractBaseRepository implements ModelNeedValidate, BaseMethodsContract
{
    const ERROR_CODE = 500;
    const NOT_FOUND_CODE = 404;
    const SUCCESS_CODE = 201;
    const SUCCESS_NO_CONTENT_CODE = 200;

    use RepositoryRules;

    use BaseMethods;

    use Cacheable;

    /**
     * @var \WebEd\Base\Core\Models\EloquentBase
     */
    private $model;

    public function __construct(BaseModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * @return \WebEd\Base\Core\Models\EloquentBase
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get model table
     * @return string
     */
    public function getTable()
    {
        return $this->getModel()->getTable();
    }

    /**
     * Get primary key
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getModel()->getPrimaryKey();
    }

    /**
     * @param string|array $messages
     * @param bool $error
     * @param int $responseCode
     * @param array $data
     * @return array
     */
    public function setMessages($messages, $error = false, $responseCode = null, $data = null)
    {
        return response_with_messages($messages, $error, $responseCode ?: $this::SUCCESS_NO_CONTENT_CODE, $data);
    }
}
