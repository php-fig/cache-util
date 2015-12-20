<?php


namespace Fig\Cache;

/**
 * Provides basic accessors for extracting item data from within a pool.
 */
trait BasicCacheItemAccessorsTrait
{

    /**
     * Returns the expiration timestamp.
     *
     * Although not part of the CacheItemInterface, this method is used by
     * the pool for extracting information for saving.
     *
     * @return \DateTime
     *   The timestamp at which this cache item should expire.
     */
    public function getExpiration() {
        return $this->expiration ?: new \DateTime('now +1 year');
    }

    /**
     * Returns the raw value, regardless of hit status.
     *
     * Although not part of the CacheItemInterface, this method is used by
     * the pool for extracting information for saving.
     *
     * @return mixed
     */
    public function getRawValue()
    {
        return $this->value;
    }
}
