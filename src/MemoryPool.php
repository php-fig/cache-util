<?php

namespace Fig\Cache;

use Psr\Cache\CacheItemPoolInterface;

/**
 * An in-memory implementation of the Pool interface.
 */
class MemoryPool implements CacheItemPoolInterface {
    use CachePoolDeferTrait;

    /**
     * The stored data in this cache pool.
     *
     * @var array
     */
    protected $data = [];

    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        if (!array_key_exists($key, $this->data) || $this->data[$key]['ttd'] < new \DateTime()) {
            $this->data[$key] = [
                'value' => NULL,
                'hit' => FALSE,
                'ttd' => NULL,
            ];
        }

        return new MemoryCacheItem($this, $key, $this->data[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(array $keys = array())
    {
        $collection = [];
        foreach ($keys as $key) {
            $collection[$key] = $this->getItem($key);
        }
        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->data = [];
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteItems(array $keys)
    {
        foreach ($keys as $key) {
            unset($this->data[$key]);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $items)
    {
        /** @var \Psr\Cache\CacheItemInterface $item  */
        foreach ($items as $item) {
            $this->data[$item->getKey()] = [
              'value' => $item->getRawValue(),
              'ttd' => $item->getExpiration(),
              'hit' => TRUE,
            ];
        }

        return true;
    }
}
