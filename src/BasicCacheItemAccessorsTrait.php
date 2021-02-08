<?php


namespace Fig\Cache;

/**
 * Provides basic accessors for extracting item data from within a pool.
 *
 * This trait is intended to be used in conjunection with BasicCacheItemTrait.
 *
 * @see BasicCacheItemTrait
 */
trait BasicCacheItemAccessorsTrait
{

    /**
     * Returns the expiration timestamp.
     *
     * Although not part of the CacheItemInterface, this method is used by
     * the pool for extracting information for saving.
     *
     * @return \DateTimeInterface
     *   The timestamp at which this cache item should expire.
     *
     * @internal
     */
    public function getExpiration(): \DateTimeInterface
    {
        return $this->expiration ?? new \DateTime('now +1 year');
    }

    /**
     * Returns the raw value, regardless of hit status.
     *
     * Although not part of the CacheItemInterface, this method is used by
     * the pool for extracting information for saving.
     *
     * @return mixed
     *
     * @internal
     */
    public function getRawValue(): mixed
    {
        return $this->value;
    }
}
