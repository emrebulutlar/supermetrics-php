<?php

namespace SocialPost\Cache\Factory;

use Exception;
use Memcached;
use Psr\SimpleCache\CacheInterface;

/**
 * Class CacheFactory
 *
 * @package SocialPost\Cache\Factory
 */
class CacheFactory
{

    /**
     * @throws Exception
     * @return CacheInterface
     */
    public static function create(): CacheInterface
    {
        throw new Exception('No cache :(');
    }

    /**
     * @return Memcached
     */
    protected static function getClient(): Memcached
    {
        return new Memcached();
    }
}
