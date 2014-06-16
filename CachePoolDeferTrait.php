<?php

namespace Psr\Cache;


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
    public function save(CacheItemInterface $item, $defer = CacheItemPoolInterface::IMMEDIATE)
    {
        $defer
          ? $this->deferred[] = $item
          :$this->write([$item]);

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
     */
    abstract protected function write(array $items);
}
