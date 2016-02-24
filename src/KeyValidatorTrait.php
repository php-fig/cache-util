<?php
namespace Fig\Cache;

/**
 * Key validator trait
 */
trait KeyValidatorTrait
{
    /**
     * Determines if the specified key is legal under PSR-6.
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
        if (!is_string($key) || empty($key)) {
            throw new InvalidArgumentException('Key should be a not empty string');
        }

        $unsupportedMatched = preg_match('#[{}()/\\\@:]#', $key);
        if ($unsupportedMatched > 0) {
            throw new InvalidArgumentException('Can\'t validate the specified key');
        }

        return true;
    }
}
