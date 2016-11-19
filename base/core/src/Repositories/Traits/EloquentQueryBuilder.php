<?php namespace WebEd\Base\Core\Repositories\Traits;

use WebEd\Base\Core\Models\EloquentBase;

trait EloquentQueryBuilder
{
    private $with = [];

    private $join = [];

    private $where = [];

    private $orWhere = [];

    private $paginate = [
        'perPage' => 0,
        'columns' => ['*'],
        'pageName' => 'page',
        'page' => null
    ];

    private $take = 0;

    private $select;

    private $skip;

    private $orderBy = [];

    private $orderByRandom = false;

    /**
     *
     * Since 2016-10-15
     *
     */
    private $groupBy;

    private $having = [];

    private $havingRaw = [];

    private $avg;

    private $min;

    private $max;

    private $whereExists = [];

    private $orWhereExists = [];

    private $whereNotExists = [];

    private $orWhereNotExists = [];

    private $inRandomOrder;

    private $when = [];

    /**
     * Eager loading
     * @param $entityName
     * @return $this
     */
    public function with($entityName)
    {
        $this->with[] = $entityName;

        return $this;
    }

    /**
     * Select fields
     * @param array $columns
     * @return $this
     */
    public function select($columns = ['*'])
    {
        if (!$columns) {
            $this->select = null;
        } else {
            $this->select = is_array($columns) ? $columns : func_get_args();
        }

        return $this;
    }

    /**
     * Where operator
     * @param string|array|\Closure $field
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function where($field, $operator = null, $value = null)
    {
        if ($field instanceof \Closure) {
            $this->where[] = $field;

            return $this;
        }
        if (is_array($field)) {
            foreach ($field as $key => $row) {
                $this->where[] = [
                    'field' => $key,
                    'compare' => '=',
                    'value' => $row
                ];
            }
        } else {
            if ($operator) {
                $this->where[] = [
                    'field' => $field,
                    'compare' => $operator,
                    'value' => $value
                ];
            }
        }

        return $this;
    }

    /**
     * Or where operator
     * @param string|array|\Closure $field
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function orWhere($field, $operator = null, $value = null)
    {
        if ($field instanceof \Closure) {
            $this->orWhere[] = $field;

            return $this;
        }
        if (is_array($field)) {
            foreach ($field as $key => $row) {
                $this->orWhere[] = [
                    'field' => $key,
                    'compare' => '=',
                    'value' => $row
                ];
            }
        } else {
            if ($operator) {
                $this->orWhere[] = [
                    'field' => $field,
                    'compare' => $operator,
                    'value' => $value
                ];
            }
        }

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
        if (is_array($field)) {
            foreach ($field as $key => $row) {
                $this->orderBy[$key] = $row;
            }
        } else {
            $this->orderBy[$field] = $value;
        }

        return $this;
    }

    /**
     * Order by random
     * @param bool $enable
     * @return $this
     */
    public function orderByRandom($enable = true)
    {
        if ($enable === true) {
            $this->orderByRandom = true;
        }

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
        if($firstTableField instanceof \Closure) {
            $this->join[$joinTo] = [
                'type' => 'leftJoin',
                'firstTableField' => $firstTableField,
            ];
        } else {
            if(!$operator || !$secondTableField) {
                return $this;
            }
        }

        $this->join[$joinTo] = [
            'type' => 'join',
            'firstTableField' => $firstTableField,
            'compare' => $operator,
            'secondTableField' => $secondTableField,
        ];

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
        if($firstTableField instanceof \Closure) {
            $this->join[$joinTo] = [
                'type' => 'leftJoin',
                'firstTableField' => $firstTableField,
            ];
        } else {
            if(!$operator || !$secondTableField) {
                return $this;
            }
        }

        $this->join[$joinTo] = [
            'type' => 'leftJoin',
            'firstTableField' => $firstTableField,
            'compare' => $operator,
            'secondTableField' => $secondTableField,
        ];

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
        if ((int)$perPage > 0) {
            $this->paginate['perPage'] = (int)$perPage;
        } else {
            $this->paginate['perPage'] = 0;
        }
        $this->paginate['columns'] = $columns;
        $this->paginate['pageName'] = $pageName;
        if ($page !== null) {
            $this->paginate['page'] = $page;
        }

        return $this;
    }

    /**
     * How many items to take?
     * @param $howManyItem
     * @return $this
     */
    public function take($howManyItem)
    {
        if ((int)$howManyItem > 0) {
            $this->take = (int)$howManyItem;
        } else {
            $this->take = 0;
        }

        return $this;
    }

    /**
     * How many items that're skipped from query?
     * @param $howManyItem
     * @return $this
     */
    public function skip($howManyItem)
    {
        if ((int)$howManyItem > 0) {
            $this->skip = (int)$howManyItem;
        } else {
            $this->skip = 0;
        }

        return $this;
    }

    /**
     * Set current paged
     * @param $paged
     * @return $this
     */
    public function setCurrentPaged($paged)
    {
        $this->paginate['page'] = (int)$paged;

        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $model = $this->_prepareQuery();

        if ($this->take === 1) {
            $result = $model->first();
        } else {
            /**
             * Paginate results
             */
            if ($this->paginate['perPage'] > 0) {
                $result = $model->paginate($this->paginate['perPage'], $this->paginate['columns'], $this->paginate['pageName'], $this->paginate['page']);
            } else {
                $result = $model->get();
            }
        }

        $this->resetQuery();

        return $result;
    }

    /**
     * Get all items
     * @return mixed
     */
    public function all()
    {
        $this->where = [];
        $this->orWhere = [];
        $this->paginate = [
            'perPage' => 0,
            'columns' => ['*'],
            'pageName' => 'page',
            'page' => null
        ];
        $this->take = 0;
        $this->skip = null;

        return $this->get();
    }

    /**
     * Get first item from db
     * @return mixed
     */
    public function first()
    {
        $this->take = 1;

        return $this->get();
    }

    /**
     * Fin item by id and other related fields
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $this->resetQuery();
        return $this->where($this->getPrimaryKey(), '=', $id)->take(1)->get();
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
     * Determine current query use join or not
     * @return bool
     */
    public function isUseJoin()
    {
        return ($this->join) ? true : false;
    }

    /**
     * @return mixed
     */
    private function _prepareQuery()
    {
        /**
         * @var EloquentBase $model
         */
        $model = $this->getModel();
        /**
         * Join tables
         */
        foreach ($this->join as $key => $row) {
            $type = $row['type'];
            if($row['firstTableField'] instanceof \Closure) {
                $model = $model->$type($key, $row['firstTableField']);
            } else {
                $model = $model->$type($key, $row['firstTableField'], $row['compare'], $row['secondTableField']);
            }
        }

        /**
         * Where condition
         */
        $model = $this->convertWhereQuery($model);
        /**
         * --------------------------------------------------
         */
        /**Since 2016-10-15**/
        foreach ($this->whereExists as $exist) {
            $model = $model->whereExists($exist);
        }
        foreach ($this->whereNotExists as $exist) {
            $model = $model->whereNotExists($exist);
        }
        foreach ($this->orWhereExists as $exist) {
            $model = $model->orWhereExists($exist);
        }
        foreach ($this->orWhereNotExists as $exist) {
            $model = $model->orWhereNotExists($exist);
        }
        foreach ($this->when as $item) {
            $model = $model->when($item[0], $item[1]);
        }
        /**
         * --------------------------------------------------
         */

        /**
         * Order by
         */
        foreach ($this->orderBy as $key => $value) {
            $model = $model->orderBy($key, $value);
        }

        /**
         * Order by random
         */
        if ($this->orderByRandom === true) {
            $model = $model->orderByRaw('RAND()');
        }

        /**
         * Custom select fields
         */
        if ((array)$this->select) {
            $model = $model->select($this->select);
        }

        /**
         * Eager loading
         */
        if ($this->with) {
            foreach ($this->with as $row) {
                $model = $model->with($row);
            }
        }

        /**
         * Skip some results
         */
        if ((int)$this->skip) {
            $model = $model->skip((int)$this->skip);
        }

        /**
         * Maximum items to get
         */
        if ((int)$this->take > 0) {
            $model = $model->take((int)$this->take);
        }

        /**
         *
         * Since 2016-10-15
         *
         */
        if ($this->groupBy) {
            $model = $model->groupBy($this->groupBy);
        }
        if ($this->having) {
            foreach ($this->having as $item) {
                $model = $model->having($item[0], $item[1], $item[2]);
            }
        }
        if ($this->havingRaw) {
            foreach ($this->havingRaw as $item) {
                $model = $model->havingRaw($item);
            }
        }
        if ($this->avg) {
            $model = $model->avg($this->avg);
        }
        if ($this->min) {
            $model = $model->min($this->min);
        }
        if ($this->max) {
            $model = $model->max($this->max);
        }
        if ($this->inRandomOrder) {
            $model = $model->inRandomOrder();
        }

        return $model;
    }

    /**
     * Reset all query builder data
     * @return mixed
     */
    public function resetQuery()
    {
        $this->with = [];
        $this->join = [];
        $this->where = [];
        $this->orWhere = [];
        $this->paginate = [
            'perPage' => 0,
            'columns' => ['*'],
            'pageName' => 'page',
            'page' => null
        ];
        $this->take = 0;
        $this->select = null;
        $this->skip = null;
        $this->orderBy = [];
        $this->orderByRandom = false;

        /**
         *
         * Since 2016-10-15
         *
         */
        $this->groupBy = null;
        $this->having = [];
        $this->havingRaw = [];
        $this->avg = null;
        $this->min = null;
        $this->max = null;
        $this->whereExists = [];
        $this->whereNotExists = [];
        $this->orWhereExists = [];
        $this->orWhereNotExists = [];
        $this->inRandomOrder = null;
        $this->when = [];

        return $this;
    }

    /**
     * Get the current query builder data
     * @return mixed
     */
    public function getQueryBuilderData()
    {
        return [
            'with' => $this->with,
            'join' => $this->join,
            'where' => $this->where,
            'orWhere' => $this->orWhere,
            'paginate' => $this->paginate,
            'take' => $this->take,
            'select' => $this->select,
            'skip' => $this->skip,
            'orderBy' => $this->orderBy,
            'orderByRandom' => $this->orderByRandom,
            /**
             *
             * Since 2016-10-15
             *
             */
            'groupBy' => $this->groupBy,
            'having' => $this->having,
            'havingRaw' => $this->havingRaw,
            'avg' => $this->avg,
            'min' => $this->min,
            'max' => $this->max,
            'whereExists' => $this->whereExists,
            'whereNotExists' => $this->whereNotExists,
            'orWhereExists' => $this->orWhereExists,
            'orWhereNotExists' => $this->orWhereNotExists,
            'inRandomOrder' => $this->inRandomOrder,
            'when' => $this->when,
        ];
    }

    /**
     * @param \WebEd\Base\Core\Models\EloquentBase $model
     * @return \WebEd\Base\Core\Models\EloquentBase
     */
    public function convertWhereQuery($model)
    {
        foreach ($this->where as $key => $row) {
            if ($row instanceof \Closure) {
                $model = $model->where($row);
            } else {
                $model = $model->where(function ($q) use ($key, $row) {
                    switch ($row['compare']) {
                        case 'LIKE':
                            $q->where($row['field'], (string)$row['compare'], '%' . (string)$row['value'] . '%');
                            break;
                        case 'IN':
                            $q->whereIn($row['field'], (array)$row['value']);
                            break;
                        case 'NOT_IN':
                            $q->whereNotIn($row['field'], (array)$row['value']);
                            break;
                        case 'BETWEEN':
                            $q->whereBetween($row['field'], (array)$row['value']);
                            break;
                        case 'NOT_BETWEEN':
                            $q->whereNotBetween($row['field'], (array)$row['value']);
                            break;
                        default:
                            if ($row['value'] != null) {
                                $q->where($row['field'], (string)$row['compare'], (string)$row['value']);
                            } else {
                                if ($row['compare'] === '=' || $row['compare'] === '==') {
                                    $q->whereNull($row['field']);
                                } else {
                                    $q->whereNotNull($row['field']);
                                }
                            }
                            break;
                    }
                });
            }
        }
        foreach ($this->orWhere as $key => $row) {
            if ($row instanceof \Closure) {
                $model = $model->orWhere($row);
            } else {
                $model = $model->orWhere(function ($q) use ($key, $row) {
                    switch ($row['compare']) {
                        case 'LIKE':
                            $q->where($row['field'], (string)$row['compare'], '%' . (string)$row['value'] . '%');
                            break;
                        case 'IN':
                            $q->whereIn($row['field'], (array)$row['value']);
                            break;
                        case 'NOT_IN':
                            $q->whereNotIn($row['field'], (array)$row['value']);
                            break;
                        case 'BETWEEN':
                            $q->whereBetween($row['field'], (array)$row['value']);
                            break;
                        case 'NOT_BETWEEN':
                            $q->whereNotBetween($row['field'], (array)$row['value']);
                            break;
                        default:
                            if ($row['value'] != null) {
                                $q->where($row['field'], (string)$row['compare'], (string)$row['value']);
                            } else {
                                if ($row['compare'] === '=' || $row['compare'] === '==') {
                                    $q->whereNull($row['field']);
                                } else {
                                    $q->whereNotNull($row['field']);
                                }
                            }
                            break;
                    }
                });
            }
        }
        return $model;
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
        $this->groupBy = $group;

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
        $this->having[] = [$field, $operator, $value];
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function havingRaw($value)
    {
        $this->havingRaw[] = $value;
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function avg($field)
    {
        $this->avg = $field;
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function min($field)
    {
        $this->min = $field;
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function max($field)
    {
        $this->max = $field;
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function whereExists(\Closure $callback)
    {
        $this->whereExists[] = $callback;
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function whereNotExists(\Closure $callback)
    {
        $this->whereNotExists[] = $callback;
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function orWhereExists(\Closure $callback)
    {
        $this->orWhereExists[] = $callback;
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function orWhereNotExists(\Closure $callback)
    {
        $this->orWhereNotExists[] = $callback;
        return $this;
    }

    /**
     * @param $bool
     * @return $this
     */
    public function inRandomOrder($bool)
    {
        $this->inRandomOrder = !!$bool;
        return $this;
    }

    /**
     * @param $bool
     * @param \Closure $callback
     * @return $this
     */
    public function when($bool, \Closure $callback)
    {
        $this->when[] = [$bool, $callback];
        return $this;
    }
}
