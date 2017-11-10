<?php

namespace Fig\Cache;

use Psr\SimpleCache\CacheInterface;

/**
 * This cache can be used to avoid conditional cache calls.
 */
class NullCache implements CacheInterface
{
    /**
     * {inheritdoc}
     */
    public function get($key, $default = null)
    {
        return $default;
    }

    /**
     * {inheritdoc}
     */
    public function getMultiple($keys, $default = null)
    {
        return $default;
    }

    /**
     * {inheritdoc}
     */
    public function set($key, $value, $ttl = null)
    {
        return true;
    }

    /**
     * {inheritdoc}
     */
    public function delete($key)
    {
        return true;
    }

    /**
     * {inheritdoc}
     */
    public function clear()
    {
        return true;
    }

    /**
     * {inheritdoc}
     */
    public function setMultiple($values, $ttl = null)
    {
        return true;
    }

    /**
     * {inheritdoc}
     */
    public function deleteMultiple($keys)
    {
        return true;
    }

    /**
     * {inheritdoc}
     */
    public function has($key)
    {
        return false;
    }
}