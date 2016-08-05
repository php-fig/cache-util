<?php

namespace Fig\Cache;

use Psr\Cache\CacheException as PsrCacheException;

/**
 * Exception for all exceptions thrown by an Implementing Library.
 */
class CacheException extends \Exception implements PsrCacheException
{
}
