<?php


namespace Fig\Cache;

/**
 * Generic method implementations common to most/all pool implementations.
 */
trait BasicPoolTrait
{
    use CachePoolDeferTrait;


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
