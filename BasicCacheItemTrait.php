<?php

namespace Psr\Cache;

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
    public function set($value = NULL, $ttl = null)
    {
        $this->value = $value;
        $this->setExpiration($ttl);
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
    public function delete()
    {
        $this->db->delete($this->key);
    }

    /**
     * {@inheritdoc}
     */
    public function exists()
    {
        return $this->hit;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpiration() {
        return $this->ttd;
    }

    /**
     * Sets the expiration for this cache item.
     *
     * @param mixed $ttl
     *   The TTL to convert to a DateTime expiration.
     */
    protected function setExpiration($ttl) {
        if ($ttl instanceof \DateTime) {
            $this->ttd = $ttl;
        }
        elseif (is_int($ttl)) {
            $this->ttd = new \DateTime('now +' . $ttl . ' seconds');
        }
        elseif (is_null($this->ttd)) {
            $this->ttd = new \DateTime('now +1 year');
        }
    }
}
