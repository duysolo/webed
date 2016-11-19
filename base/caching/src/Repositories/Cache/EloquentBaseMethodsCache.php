<?php namespace WebEd\Base\Caching\Repositories\Cache;

use WebEd\Base\Core\Models\EloquentBase;

trait EloquentBaseMethodsCache
{
    /**
     * Eager loading
     * @param $entityName
     * @return $this
     */
    public function with($entityName)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Select fields
     * @param array $columns
     * @return $this
     */
    public function select($columns = ['*'])
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Where operator
     * @param $field
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function where($field, $operator = null, $value = null)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Or where operator
     * @param $field
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function orWhere($field, $operator = null, $value = null)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Order by
     * @param $field
     * @param null $value
     * @return $this
     */
    public function orderBy($field, $value = null)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Order by random
     * @param bool $enable
     * @return $this
     */
    public function orderByRandom($enable = true)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Join to other table
     * @param $joinTo
     * @param $firstTableField
     * @param $operator
     * @param $secondTableField
     * @return $this
     */
    public function join($joinTo, $firstTableField, $operator = null, $secondTableField = null)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Left join to other table
     * @param $joinTo
     * @param $firstTableField
     * @param $operator
     * @param $secondTableField
     * @return $this
     */
    public function leftJoin($joinTo, $firstTableField, $operator = null, $secondTableField = null)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param null $page
     * @return $this
     */
    public function paginate($perPage, $columns = ['*'], $pageName = 'page', $page = null)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * How many items to take?
     * @param $howManyItem
     * @return $this
     */
    public function take($howManyItem)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * How many items that're skipped from query?
     * @param $howManyItem
     * @return $this
     */
    public function skip($howManyItem)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Set current paged
     * @param $paged
     * @return $this
     */
    public function setCurrentPaged($paged)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Fetch data from query builder
     * @return mixed
     */
    public function get()
    {
        return $this->beforeGet(__FUNCTION__, $this->getQueryBuilderData());
    }

    /**
     * Get all items
     * @return mixed
     */
    public function all()
    {
        return $this->beforeGet(__FUNCTION__, $this->getQueryBuilderData());
    }

    /**
     * Get first item from db
     * @return mixed
     */
    public function first()
    {
        return $this->beforeGet(__FUNCTION__, $this->getQueryBuilderData());
    }

    /**
     * Fin item by id and other related fields
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrNew($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * Find item by fields. If not exist, create a new one with these fields
     * @param array $fields
     * @param array $optionalFields
     * @param bool $forceCreate
     * @return EloquentBase
     */
    public function findByFieldsOrCreate($fields, $optionalFields = null, $forceCreate = false)
    {
        $result = $this->where($fields)->take(1)->get();

        if (!$result) {
            $data = array_merge((array)$optionalFields, $fields);
            if ($forceCreate) {
                $this->forceCreate($data);
            } else {
                $this->create($data);
            }
            return $this->where($fields)->take(1)->get();
        }
        return $result;
    }

    /**
     * Reset all query builder data
     * @return mixed
     */
    public function resetQuery()
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * Get the current query builder data
     * @return mixed
     */
    public function getQueryBuilderData()
    {
        return call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
    }

    /**
     * Create a new item.
     * Only fields listed in $fillable of model can be filled
     * @param array $data
     * @return static model
     */
    public function create(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Create a new item, no validate
     * @param $data
     * @return \WebEd\Base\Core\Models\EloquentBase
     */
    public function forceCreate(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Validate model then edit
     * @param \WebEd\Base\Core\Models\EloquentBase|\Illuminate\Database\Eloquent\Model|int $id
     * @param $data
     * @param bool $allowCreateNew
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function editWithValidate($id, array $data, $allowCreateNew = false, $justUpdateSomeFields = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Find items by ids and edit them
     * @param $ids
     * @param $data
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function updateMultiple(array $ids, array $data, $justUpdateSomeFields = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Find items by fields and edit them
     * @param array $fields
     * @param $data
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function update(array $data, $justUpdateSomeFields = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Delete items by id
     * @param int|array|null $id
     * @return mixed
     */
    public function delete($id = null)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * Determine current query use join or not
     * @return bool
     */
    public function isUseJoin()
    {
        return (array_get($this->getQueryBuilderData(), 'join', null)) ? true : false;
    }

    /**
     *
     * Since 2016-10-15
     *
     */
    /**
     * @param $group
     * @return $this
     */
    public function groupBy($group)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param $field
     * @param $operator
     * @param $value
     * @return $this
     */
    public function having($field, $operator, $value)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function avg($field)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function min($field)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function max($field)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function whereExists(\Closure $callback)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function whereNotExists(\Closure $callback)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function orWhereExists(\Closure $callback)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function orWhereNotExists(\Closure $callback)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param $bool
     * @return $this
     */
    public function inRandomOrder($bool)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }

    /**
     * @param $bool
     * @param \Closure $callback
     * @return $this
     */
    public function when($bool, \Closure $callback)
    {
        call_user_func_array([$this->repository, __FUNCTION__], func_get_args());
        return $this;
    }
}
