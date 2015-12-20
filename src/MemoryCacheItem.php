<?php

namespace Fig\Cache;

use Psr\Cache\CacheItemInterface;

/**
 * In-memory implementation of a cache item.
 */
class MemoryCacheItem implements CacheItemInterface {
    use BasicCacheItemTrait;

    /**
     * Constructs a new MemoryCacheItem.
     *
     * @param string $key
     *   The key of the cache item this object represents.
     * @param array $data
     *   An associative array of data from the Memory Pool.
     */
    public function  __construct($key, array $data) {
        $this->key = $key;
        $this->value = $data['value'];
        $this->expiration = $data['ttd'];
        $this->hit = $data['hit'];
    }

    /**
     * Returns the stored value regardless of hit status.
     *
     * This method is intended for use only by the MemoryPool. Other callers
     * should not use it.
     *
     * @internal
     *
     * @return mixed
     *   The stored value.
     */
    public function getRawValue()
    {
        return $this->value;
    }
}
