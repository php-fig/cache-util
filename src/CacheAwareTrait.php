<?php

namespace Fig\Cache;

use Psr\SimpleCache\CacheInterface;

/**
 * Basic Implementation of CacheAwareInterface.
 */
trait CacheAwareTrait
{
    /**
     * The cache instance.
     *
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Sets a cache.
     *
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }
}
