<?php

namespace Fig\Cache;

use Psr\Cache\InvalidArgumentException as PsrCacheInvalidArgumentException;

/**
 * Exception interface for invalid cache arguments.
 *
 * Any time an invalid argument is passed into a method it must throw an
 * exception class which implements Psr\Cache\InvalidArgumentException.
 */
class InvalidArgumentException extends \InvalidArgumentException implements PsrCacheInvalidArgumentException
{
}
