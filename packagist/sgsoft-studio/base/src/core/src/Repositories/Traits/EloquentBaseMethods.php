<?php namespace WebEd\Base\Core\Repositories\Traits;

use WebEd\Base\Core\Models\Contracts\BaseModelContract;

trait EloquentBaseMethods
{
    use EloquentQueryBuilder;

    /**
     * Create a new item.
     * Only fields listed in $fillable of model can be filled
     * @param array $data
     * @return static model
     */
    public function create(array $data)
    {
        return $this->getModel()->create($data);
    }

    /**
     * Create a new item, no validate
     * @param $data
     * @return \WebEd\Base\Core\Models\Contracts\BaseModelContract
     */
    public function forceCreate(array $data)
    {
        return $this->getModel()->forceCreate($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrNew($id)
    {
        $model = $this->getModel();
        return $this->find($id) ?: new $model;
    }

    /**
     * Validate model then edit
     * @param \WebEd\Base\Core\Models\Contracts\BaseModelContract|int|null $id
     * @param $data
     * @param bool $allowCreateNew
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function editWithValidate($id, array $data, $allowCreateNew = false, $justUpdateSomeFields = false)
    {
        if ($id instanceof BaseModelContract) {
            $item = $id;
        } else {
            $id = (int)$id;
            if ($allowCreateNew != true) {
                $item = $this->find($id);
                if (!$item) {
                    return $this->setMessages(['Model not exists with id: ' . $id], true, $this::NOT_FOUND_CODE);
                }
            } else {
                $item = $this->findOrNew($id);
            }
        }

        /**
         * Unset some data that not changed
         */
        if ($item->{$item->getPrimaryKey()}) {
            $this->unsetNotChangedData($item, $data);
        }

        /**
         * Unset not editable fields
         */
        $cannotEdit = collect($this->unsetNotEditableFields($data));
        if ($cannotEdit->count()) {
            $cannotEdit = ['Cannot edit these fields: ' . $cannotEdit->implode(', ')];
        } else {
            $cannotEdit = [];
        }

        /**
         * Nothing to update
         */
        if (!$data) {
            return $this->setMessages(array_merge(['Request completed'], $cannotEdit), false, $this::SUCCESS_NO_CONTENT_CODE, $item);
        }

        /**
         * Validate model
         */
        $validate = $this->validateModel($data, $justUpdateSomeFields);

        /**
         * Do not passed validate
         */
        if (!$validate) {
            return $this->setMessages(array_merge($this->getRuleErrorMessages(), $cannotEdit), true, $this::ERROR_CODE);
        }

        $primaryKey = $this->getPrimaryKey();
        /**
         * Prevent edit the primary key
         */
        if (isset($data[$primaryKey])) {
            unset($data[$primaryKey]);
        }

        foreach ($data as $key => $row) {
            $item->$key = $row;
        }

        try {
            $item->save();
        } catch (\Exception $exception) {
            $this->resetQuery();
            return $this->setMessages(array_merge([$exception->getMessage()], $cannotEdit), true, $this::ERROR_CODE);
        }
        $this->resetQuery();
        return $this->setMessages(array_merge(['Request completed'], $cannotEdit), false, $this::SUCCESS_CODE, $item);
    }

    /**
     * Find items by ids and edit them
     * @param array $ids
     * @param array $data
     * @param bool $justUpdateSomeFields
     * @return array
     */
    public function updateMultiple(array $ids, array $data, $justUpdateSomeFields = false)
    {
        /**
         * Unset not editable fields
         */
        $cannotEdit = collect($this->unsetNotEditableFields($data));
        if ($cannotEdit->count()) {
            $cannotEdit = ['Cannot update these fields' . $cannotEdit->implode(', ')];
        } else {
            $cannotEdit = [];
        }

        $validate = $this->validateModel($data, $justUpdateSomeFields);
        if (!$validate) {
            return $this->setMessages(array_merge($this->getRuleErrorMessages(), $cannotEdit), true, $this::ERROR_CODE);
        }

        $items = $this->getModel()->whereIn('id', $ids);

        try {
            $items->update($data);
        } catch (\Exception $exception) {
            $this->resetQuery();
            return $this->setMessages(array_merge([$exception->getMessage()], $cannotEdit), true, $this::ERROR_CODE);
        }
        $this->resetQuery();
        return $this->setMessages(array_merge(['Request completed'], $cannotEdit), false, $this::SUCCESS_NO_CONTENT_CODE);
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
        /**
         * Unset not editable fields
         */
        $cannotEdit = collect($this->unsetNotEditableFields($data));
        if ($cannotEdit->count()) {
            $cannotEdit = ['Cannot update these fields' . $cannotEdit->implode(', ')];
        } else {
            $cannotEdit = [];
        }

        $validate = $this->validateModel($data, $justUpdateSomeFields);
        if (!$validate) {
            return $this->setMessages(array_merge($this->getRuleErrorMessages(), $cannotEdit), true, $this::ERROR_CODE);
        }

        $model = $this->getModel();
        /**
         * Where condition
         */
        $model = $this->convertWhereQuery($model);

        try {
            $model->update($data);
        } catch (\Exception $exception) {
            $this->resetQuery();
            return $this->setMessages(array_merge([$exception->getMessage()], $cannotEdit), true, $this::ERROR_CODE);
        }
        $this->resetQuery();
        return $this->setMessages(array_merge(['Request completed'], $cannotEdit), false, $this::SUCCESS_NO_CONTENT_CODE);
    }

    /**
     * Delete items by id
     * @param \WebEd\Base\Core\Models\Contracts\BaseModelContract|int|array|null $id
     * @return mixed
     */
    public function delete($id = null)
    {
        $models = $this->getModel();

        if ($id) {
            if (is_array($id)) {
                $models = $this->getModel()->whereIn('id', $id);
            } elseif ($id instanceof BaseModelContract) {
                $models = $id;
            } else {
                $models = $this->getModel()->where('id', '=', $id);
            }
        } else {
            $models = $this->convertWhereQuery($models);
        }

        /**
         * In order to use method delete from Eloquent
         * Comment this line to use delete method in QueryBuilder
         */
        $models = $models->get();

        try {
            /**
             * In order to use method delete from Eloquent
             * Uncomment this line to use delete method in QueryBuilder
             */
            //$model->delete();
            foreach ($models as $model) {
                $model->delete();
            }
        } catch (\Exception $exception) {
            $this->resetQuery();
            return $this->setMessages([$exception->getMessage()], true, $this::ERROR_CODE);
        }
        $this->resetQuery();
        return $this->setMessages(['Request completed'], false, $this::SUCCESS_NO_CONTENT_CODE);
    }
}
