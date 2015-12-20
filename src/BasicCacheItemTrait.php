<?php

namespace Fig\Cache;

/**
 * Basic implementation of a backend-agnostic cache item.
 *
 * @implements \Psr\Cache\CacheItemInterface
 */
trait BasicCacheItemTrait {

    /**
     * @var string
     */
    protected $key;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var boolean
     */
    protected $hit;

    /**
     * @var \DateTime
     */
    protected $expiration;

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->isHit() ? $this->value : NULL;
    }

    /**
     * {@inheritdoc}
     */
    public function set($value = NULL)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isHit()
    {
        return $this->hit;
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAt($expiration) {
        if (is_null($expiration)) {
            $this->expiration = new \DateTime('now +1 year');
        } else {
            assert('$expiration instanceof \DateTimeInterface');
            $this->expiration = $expiration;
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function expiresAfter($time) {
        if (is_null($time)) {
            $this->expiration = new \DateTime('now +1 year');
        } elseif (is_numeric($time)) {
            $this->expiration = new \DateTime('now +' . $time . ' seconds');
        } else {
            assert('$time instanceof DateInterval');
            $expiration = new \DateTime();
            $expiration->add($time);
            $this->expiration = $expiration;
        }
        return $this;
    }

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
        return $this->expiration;
    }
}
