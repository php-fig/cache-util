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
    public function deleteItem(string $key): bool
    {
        return $this->deleteItems([$key]);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function deleteItems(array $items): bool;
}
