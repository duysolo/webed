<?php namespace WebEd\Base\Caching\Repositories;

use WebEd\Base\Core\Repositories\AbstractBaseRepository;
use WebEd\Base\Core\Repositories\Contracts\BaseMethodsContract;

use WebEd\Base\Caching\Repositories\Cache\EloquentBaseMethodsCache;
use WebEd\Base\Caching\Services\Contracts\CacheableContract;
use WebEd\Base\Caching\Repositories\Traits\Cacheable;

abstract class AbstractRepositoryCacheDecorator implements BaseMethodsContract
{
    use EloquentBaseMethodsCache;

    /**
     * @var AbstractBaseRepository|Cacheable
     */
    private $repository;

    /**
     * @var \WebEd\Base\Caching\Services\CacheService
     */
    private $cache;

    /**
     * @param CacheableContract $repository
     */
    public function __construct(CacheableContract $repository)
    {
        $this->repository = $repository;

        $this->cache = app(\WebEd\Base\Caching\Services\Contracts\CacheServiceContract::class);

        $this->cache
            ->setCacheObject($this->repository)
            ->setCacheLifetime(config('webed-caching.repository.lifetime'))
            ->setCacheFile(config('webed-caching.repository.store_keys'));
    }

    /**
     * When called to an inaccessable method => try to call method in repository
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->repository, $method], $parameters);
    }

    /**
     * @return AbstractBaseRepository|Traits\Cacheable
     */
    final public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return \WebEd\Base\Caching\Services\CacheService
     */
    final public function getCacheInstance()
    {
        return $this->cache;
    }

    final public function setCacheLifetime($lifetime)
    {
        $this->cache->setCacheLifetime($lifetime);

        return $this;
    }

    final public function setCacheFile($file)
    {
        $this->cache->setCacheFile($file);

        return $this;
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    final public function beforeGet($method, $parameters)
    {
        $this->cache->setCacheKey($method, $parameters);

        return $this->cache->retrieveFromCache(function () use ($method, $parameters) {
            return call_user_func_array([$this->repository, $method], $parameters);
        });
    }

    /**
     * @param $method
     * @param $parameters
     * @param bool $flushCache
     * @return mixed
     */
    final public function afterUpdate($method, $parameters, $flushCache = true)
    {
        $result = call_user_func_array([$this->repository, $method], $parameters);

        if ($flushCache === true && is_array($result) && isset($result['error']) && !$result['error']) {
            $this->cache->flushCache();
        }
        return $result;
    }
}
