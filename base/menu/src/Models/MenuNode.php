<?php namespace WebEd\Base\Menu\Models;

use WebEd\Base\Menu\Models\Contracts\MenuNodeModelContract;
use WebEd\Base\Core\Models\EloquentBase as BaseModel;

class MenuNode extends BaseModel implements MenuNodeModelContract
{
    protected $table = 'menu_nodes';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public $timestamps = true;

    protected $relatedModelInfo = [];

    public function getResolvedTitleAttribute()
    {
        if(!$this->resolveRelatedModel()) {
            return '';
        }

        return array_get($this->relatedModelInfo, 'model_title');
    }

    public function getResolvedUrlAttribute()
    {
        if(!$this->resolveRelatedModel()) {
            return $this->url;
        }

        return array_get($this->relatedModelInfo, 'url');
    }

    private function resolveRelatedModel()
    {
        if($this->type === 'custom-link') {
            return null;
        }
        $this->relatedModelInfo = \MenuManagement::getObjectInfoByType($this->type, $this->related_id);

        return $this->relatedModelInfo;
    }
}
