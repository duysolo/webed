<?php namespace WebEd\Plugins\Blog\Models;

use WebEd\Base\Users\Models\EloquentUser;
use WebEd\Plugins\Blog\Models\Contracts\PostModelContract;
use WebEd\Base\Core\Models\EloquentBase as BaseModel;

class Post extends BaseModel implements PostModelContract
{
    protected $table = 'posts';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public $timestamps = true;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'posts_categories', 'post_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(EloquentUser::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modiffier()
    {
        return $this->belongsTo(EloquentUser::class, 'updated_by');
    }
}
