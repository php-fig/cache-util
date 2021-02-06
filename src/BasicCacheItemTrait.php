<?php

namespace Fig\Cache;

/**
 * Basic implementation of a backend-agnostic cache item.
 *
 * @implements \Psr\Cache\CacheItemInterface
 */
trait BasicCacheItemTrait
{

    protected string $key;

    protected mixed $value;

    protected bool $hit;

    protected ?\DateTimeInterface $expiration;

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): mixed
    {
        return $this->isHit() ? $this->value : null;
    }

    /**
     * {@inheritdoc}
     */
    public function set($value = null): static
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isHit(): bool
    {
        return $this->hit;
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAt(?\DateTimeInterface $expiration): static
    {
        $this->expiration = $expiration ?? new \DateTimeImmutable('now +1 year');

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAfter(int|\DateInterval|null $time): static
    {
        $this->expiration = match(true) {
            is_null($time) => new \DateTimeImmutable('now +1 year'),
            is_int($time) => new \DateTimeImmutable('now +' . $time . ' seconds'),
            $time instanceof \DateInterval => (new \DateTimeImmutable())->add($time),
        };
        return $this;
    }
}
