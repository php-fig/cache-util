<?php


namespace Fig\Cache;

/**
 * Generic method implementations common to most/all pool implementations.
 */
trait BasicPoolTrait
{
    use CachePoolDeferTrait;
    
    /**
     * Characters which cannot be used in cache key.
     *
     * The following characters are reserved for future extensions and MUST NOT be 
     * supported by implementing libraries
     */
    const RESERVED_KEY_CHARACTERS = '{}()/\@:';

    /**
     * {@inheritdoc}
     */
    public function deleteItem($key)
    {
        return $this->deleteItems([$key]);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function deleteItems(array $items);
}
