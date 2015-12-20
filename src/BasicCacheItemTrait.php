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
        return $this->expiration;
    }

    /**
     * {@inheritdoc}
     */
    protected function setExpiration($ttl = null) {
        if ($ttl instanceof \DateTime) {
            $this->expiration = $ttl;
        }
        elseif (is_numeric($ttl)) {
            $this->expiration = new \DateTime('now +' . $ttl . ' seconds');
        }
        elseif (is_null($ttl)) {
            $this->expiration = new \DateTime('now +1 year');
        }
        return $this;
    }
}
