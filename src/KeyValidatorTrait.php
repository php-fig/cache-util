<?php


namespace Fig\Cache;

use Psr\Cache\InvalidArgumentException;

trait KeyValidatorTrait
{

    /**
     * Determines if the specified key is legal under PSR-6.
     *
     * @todo Actually implement this.
     *
     * @param string $key
     *   The key to validate.
     * @throws InvalidArgumentException
     *   An exception implementing The Cache InvalidArgumentException interface
     *   will be thrown if the key does not validate.
     * @return bool
     *   TRUE if the specified key is legal.
     */
    protected function validateKey($key)
    {
        return true;
    }
}
