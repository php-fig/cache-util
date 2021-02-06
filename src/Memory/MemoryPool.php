<?php

namespace Fig\Cache\Memory;

use Fig\Cache\BasicPoolTrait;
use Fig\Cache\KeyValidatorTrait;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * An in-memory implementation of the Pool interface.
 *
 * This class is not especially useful in production, but could be used
 * for testing purposes.
 */
class MemoryPool implements CacheItemPoolInterface
{
    use BasicPoolTrait;
    use KeyValidatorTrait;

    /**
     * The stored data in this cache pool.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * {@inheritdoc}
     */
    public function getItem($key): CacheItemInterface
    {
        // This method will either return True or throw an appropriate exception.
        $this->validateKey($key);

        if (!$this->hasItem($key)) {
            $this->data[$key] = $this->emptyItem();
        }

        return new MemoryCacheItem($key, $this->data[$key]);
    }

    /**
     * Returns an empty item definition.
     *
     * @return array
     */
    protected function emptyItem(): array
    {
        return [
            'value' => null,
            'hit' => false,
            'ttd' => null,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(array $keys = []): iterable
    {
        // This method will throw an appropriate exception if any key is not valid.
        array_map([$this, 'validateKey'], $keys);

        $collection = [];
        foreach ($keys as $key) {
            $collection[$key] = $this->getItem($key);
        }
        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): bool
    {
        $this->data = [];
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            unset($this->data[$key]);
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem($key): bool
    {
        return array_key_exists($key, $this->data) && $this->data[$key]['ttd'] > new \DateTimeImmutable();
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $items): bool
    {
        /** @var \Psr\Cache\CacheItemInterface $item  */
        foreach ($items as $item) {
            $this->data[$item->getKey()] = [
                // Assumes use of the BasicCacheItemAccessorsTrait.
                'value' => $item->getRawValue(),
                'ttd' => $item->getExpiration(),
                'hit' => true,
            ];
        }

        return true;
    }
}
