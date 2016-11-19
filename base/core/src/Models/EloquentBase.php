<?php namespace WebEd\Base\Core\Models;

use Illuminate\Database\Eloquent\Model;
use WebEd\Base\Core\Models\Contracts\BaseModelContract;

abstract class EloquentBase extends Model implements BaseModelContract
{
    /**
     * Set primary key of model
     * @var string
     */
    protected $primaryKey = false;

    /**
     * Get primary key
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * This is where to put some scope query
     */
}
