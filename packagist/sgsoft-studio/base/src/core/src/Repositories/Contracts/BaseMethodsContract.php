<?php namespace WebEd\Base\Core\Repositories\Contracts;

use WebEd\Base\Core\Models\EloquentBase;

interface BaseMethodsContract
{
    /**
     * Eager loading
     * @param $entityName
     * @return $this
     */
    public function with($entityName);

    /**
     * Select fields
     * @param array $columns
     * @return $this
     */
    public function select($columns = ['*']);

    /**
     * Where operator
     * @param string|array|\Closure $field
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function where($field, $operator = null, $value = null);

    /**
     * Or where operator
     * @param string|array|\Closure $field
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function orWhere($field, $operator = null, $value = null);

    /**
     * Order by
     * @param $field
     * @param null $value
     * @return $this
     */
    public function orderBy($field, $value = null);

    /**
     * Order by random
     * @param bool $enable
     * @return $this
     */
    public function orderByRandom($enable = true);

    /**
     * Join to other table
     * @param $joinTo
     * @param $firstTableField
     * @param $operator
     * @param $secondTableField
     * @return $this
     */
    public function join($joinTo, $firstTableField, $operator = null, $secondTableField = null);

    /**
     * Left join to other table
     * @param $joinTo
     * @param $firstTableField
     * @param $operator
     * @param $secondTableField
     * @return $this
     */
    public function leftJoin($joinTo, $firstTableField, $operator = null, $secondTableField = null);

    /**
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param null $page
     * @return $this
     */
    public function paginate($perPage, $columns = ['*'], $pageName = 'page', $page = null);

    /**
     * How many items to take?
     * @param $howManyItem
     * @return $this
     */
    public function take($howManyItem);

    /**
     * How many items that're skipped from query?
     * @param $howManyItem
     * @return $this
     */
    public function skip($howManyItem);

    /**
     * Set current paged
     * @param $paged
     * @return $this
     */
    public function setCurrentPaged($paged);

    /**
     * @return mixed
     */
    public function get();

    /**
     * Get all items
     * @return mixed
     */
    public function all();

    /**
     * Get first item from db
     * @return mixed
     */
    public function first();

    /**
     * Fin item by id and other related fields
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Find item by fields. If not exist, create a new one with these fields
     * @param array $fields
     * @param array $optionalFields
     * @param bool $forceCreate
     * @return EloquentBase
     */
    public function findByFieldsOrCreate($fields, $optionalFields = null, $forceCreate = false);

    /**
     * Reset all query builder data
     * @return mixed
     */
    public function resetQuery();

    /**
     * Get the current query builder data
     * @return mixed
     */
    public function getQueryBuilderData();

    /**
     * Create a new item.
     * Only fields listed in $fillable of model can be filled
     * @param array $data
     * @return static model
     */
    public function create(array $data);

    /**
     * Create a new item, no validate
     * @param $data
     * @return \WebEd\Base\Core\Models\EloquentBase
     */
    public function forceCreate(array $data);

    /**
     * @param $id
     * @return \WebEd\Base\Core\Models\EloquentBase
     */
    public function findOrNew($id);

    /**
     * Validate model then edit
     * @param \WebEd\Base\Core\Models\EloquentBase|\Illuminate\Database\Eloquent\Model|int $id
     * @param $data
     * @param bool $allowCreateNew
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function editWithValidate($id, array $data, $allowCreateNew = false, $justUpdateSomeFields = false);

    /**
     * Find items by ids and edit them
     * @param $ids
     * @param $data
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function updateMultiple(array $ids, array $data, $justUpdateSomeFields = false);

    /**
     * Find items by fields and edit them
     * @param $data
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function update(array $data, $justUpdateSomeFields = false);

    /**
     * Delete items by id
     * @param int|array $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Determine current query use join or not
     * @return bool
     */
    public function isUseJoin();

    /**
     *
     * Since 2016-10-15
     *
     */
    /**
     * @param $group
     * @return $this
     */
    public function groupBy($group);

    /**
     * @param $field
     * @param $operator
     * @param $value
     * @return $this
     */
    public function having($field, $operator, $value);

    /**
     * @param $field
     * @return $this
     */
    public function avg($field);

    /**
     * @param $field
     * @return $this
     */
    public function min($field);

    /**
     * @param $field
     * @return $this
     */
    public function max($field);

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function whereExists(\Closure $callback);

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function whereNotExists(\Closure $callback);

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function orWhereExists(\Closure $callback);

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function orWhereNotExists(\Closure $callback);

    /**
     * @param $bool
     * @return bool
     */
    public function inRandomOrder($bool);

    /**
     * @param $bool
     * @param \Closure $callback
     * @return $this
     */
    public function when($bool, \Closure $callback);
}
