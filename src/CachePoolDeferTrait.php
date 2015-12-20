<?php

namespace Fig\Cache;

use Psr\Cache\CacheItemInterface;


/**
 * Utility implementation of the deferring logic for cache pools.
 */
trait CachePoolDeferTrait {

    /**
     * Deferred cache items to be saved later.
     *
     * @var CacheItemInterface[]
     */
    protected $deferred = [];

    /**
     * {@inheritdoc}
     */
    public function save(CacheItemInterface $item)
    {
        $this->write([$item]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function saveDeferred(CacheItemInterface $item)
    {
        $this->deferred[] = $item;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        $success = $this->write($this->deferred);
        if ($success) {
            $this->deferred = [];
        }
        return $success;
    }

    /**
     * Commits the specified cache items to storage.
     *
     * @param CacheItemInterface[] $items
     *
     * @return bool
     *   TRUE if all provided items were successfully saved. FALSE otherwise.
     */
    abstract protected function write(array $items);
}
