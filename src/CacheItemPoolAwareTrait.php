<?php

namespace Fig\Cache;

use Psr\Cache\CacheItemPoolInterface;

/**
 * Basic Implementation of CacheItemPoolAwareInterface.
 */
trait CacheItemPoolAwareTrait
{
    /** @var CacheItemPoolInterface */
    protected $cacheItemPool;

    /**
     * Sets a CacheItemPool.
     *
     * @param CacheItemPoolInterface $CacheItemPool
     */
    public function setCacheItemPool(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cacheItemPool = $cacheItemPool;
    }
}
