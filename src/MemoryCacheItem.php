<?php

namespace Fig\Cache;

use Psr\Cache\CacheItemInterface;

/**
 * In-memory implementation of a cache item.
 */
class MemoryCacheItem implements CacheItemInterface {
    use BasicCacheItemTrait;
    use BasicCacheItemAccessorsTrait;

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
}
