<?php namespace WebEd\Base\Menu\Repositories;

use WebEd\Base\Core\Repositories\AbstractBaseRepository;
use WebEd\Base\Caching\Services\Contracts\CacheableContract;

use WebEd\Base\Menu\Repositories\Contracts\MenuNodeRepositoryContract;

class MenuNodeRepository extends AbstractBaseRepository implements MenuNodeRepositoryContract, CacheableContract
{
    protected $rules = [

    ];

    protected $editableFields = [
        '*',
    ];
}
