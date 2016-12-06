<?php namespace WebEd\Plugins\Blog\Models;

use WebEd\Base\Users\Models\EloquentUser;
use WebEd\Plugins\Blog\Models\Contracts\CategoryModelContract;
use WebEd\Base\Core\Models\EloquentBase as BaseModel;

class Category extends BaseModel implements CategoryModelContract
{
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'slug', 'status', 'parent_id', 'page_template',
        'description', 'content', 'thumbnail', 'keywords', 'order',
        'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_categories', 'category_id', 'post_id');
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
