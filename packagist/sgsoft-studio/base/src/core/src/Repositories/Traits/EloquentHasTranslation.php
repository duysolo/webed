<?php namespace WebEd\Base\Core\Repositories\Traits;

use WebEd\Base\Core\Models\Contracts\HasTranslationContract;

trait EloquentHasTranslation
{
    /**
     * @var \WebEd\Base\Core\Repositories\TranslationsMapperRepository
     */
    protected $translationsMapperRepository;

    public function getTranslationsMapperRepository()
    {
        if (!$this->translationsMapperRepository) {
            $this->translationsMapperRepository = app()->make(\WebEd\Base\Core\Repositories\Contracts\TranslationsMapperContract::class);
        }
        return $this->translationsMapperRepository;
    }

    /**
     * @return string
     */
    public function getTranslationsMapperTable()
    {
        return property_exists($this, 'translationsMapperTable') ? $this->translationsMapperTable : 'translations_mapper';
    }

    /**
     * @param $tableName
     * @return $this
     */
    public function setTranslationsMapperTable($tableName)
    {
        $this->translationsMapperTable = $tableName;

        return $this;
    }

    /**
     * @param $id
     * @param $languageId
     * @return mixed
     */
    public function getTranslationById($id, $languageId = null)
    {
        if ($id instanceof HasTranslationContract) {
            $entity = $id;
        } else {
            $entity = $this->find((int)$id);
        }
        if (!$entity) {
            return $this->setMessages(['Model item not exists with this id:' . $id], true, $this::NOT_FOUND_CODE);
        }

        $mapper = $entity->translations();

        /**
         * Just get 1 item
         */
        if ($languageId !== null) {
            $mapper = $mapper->where('language_id', '=', $languageId)
                ->first();
            if ($mapper) {
                return $this->find($mapper->map_from_id);
            }
            return null;
        }

        /**
         * Get collection
         */
        $mapper = $mapper->select('map_from_id')
            ->get()->toArray();
        $mapperIds = [];
        foreach ($mapper as $row) {
            $value = array_get($row, 'map_from_id');
            if ($value) {
                $mapperIds[] = $value;
            }
        }
        return $this->where('id', 'IN', $mapperIds)->get();
    }

    public function getWithDefaultLanguage($defaultLanguageId)
    {
        $mapper = $this->getTranslationsMapperRepository()
            ->where('language_id', '=', $defaultLanguageId)
            ->select('map_from_id')
            ->get()->toArray();
        $mapperIds = [];
        foreach ($mapper as $row) {
            $value = array_get($row, 'map_from_id');
            if ($value) {
                $mapperIds[] = $value;
            }
        }

        return $this->where('id', 'IN', $mapperIds)->get();
    }

    public function saveTranslation($entityId, $languageId, array $data)
    {
        /**
         * Create new
         */
        if ((int)$entityId === 0) {
            $result = $this->editWithValidate(0, $data, true, false);
            if ($result['error']) {
                return $result;
            }

            $entityInstance = $result['data'];

            /**
             * Map translation
             */
            $resultMapping = $this->getTranslationsMapperRepository()
                ->editWithValidate(0, [
                    'map_from_id' => $entityInstance->id,
                    'map_to_id' => $entityInstance->id,
                    'language_id' => $languageId,
                    'map_class' => get_class($this->getModel()),
                ], true, false);
            if ($resultMapping['error']) {
                $result['messages'] = array_merge($result['messages'], [
                    'Cannot create translation mapper'
                ]);
            }
            return $result;
        }

        /**
         * Edit
         */
        $globalEntity = $this->find($entityId);

        if (!$globalEntity) {
            return $this->setMessages(['Model item not exists with this id:' . $entityId], true, $this::NOT_FOUND_CODE);
        }

        $mapper = $globalEntity->translations()
            ->where('language_id', '=', $languageId)
            ->first();
        if ($mapper) {
            /**
             * Has translation
             */
            $result = $this->editWithValidate($mapper->map_from_id, $data, false, true);
        } else {
            /**
             * Create new translation
             */
            $result = $this->editWithValidate(0, $data, true, false);
        }

        if ($result['error']) {
            return $result;
        }

        /**
         * Create map field
         */
        if (!$mapper) {
            $class = $this->getTranslationsMapperRepository()->getModel()->getMorphClass();
            $mapper = new $class;
            $mapper->language_id = $languageId;
            $mapper->map_from_id = $result['data']->id;

            $globalEntity->translations()->save($mapper);
        }

        return $result;
    }
}
