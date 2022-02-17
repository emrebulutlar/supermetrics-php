<?php

namespace SocialPost\Client;

use Closure;
use GuzzleHttp\Utils;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class SocialDriverCacheDecorator
 *
 * @package SocialPost\Driver
 */
class SocialClientCacheDecorator implements SocialClientInterface
{

    //TODO: set cache ttl via .env
    private const CACHE_TTL = 60 * 60; //hour

    /**
     * SocialDriverCacheDecorator constructor.
     *
     * @param SocialClientInterface $fallbackClient
     * @param CacheInterface        $cache
     * @param string                $cachePrefix
     */
    public function __construct(
        private readonly SocialClientInterface $fallbackClient,
        private readonly CacheInterface $cache,
        private readonly string $cachePrefix
    ) {
    }

    /**
     * @param string $url
     * @param array  $parameters
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function get(string $url, array $parameters): string
    {
        return $this->getData(
            function () use ($url, $parameters) {
                return $this->fallbackClient->get($url, $parameters);
            },
            $this->assembleCacheKey($url, $parameters)
        );
    }

    /**
     * @param string $url
     * @param array  $body
     *
     * @return string
     */
    public function post(string $url, array $body): string
    {
        return $this->fallbackClient->authRequest($url, $body);
    }

    /**
     * @param string $url
     * @param array  $body
     *
     * @return string
     */
    public function authRequest(string $url, array $body): string
    {
        return $this->fallbackClient->authRequest($url, $body);
    }

    /**
     * @param Closure $callback
     * @param string  $key
     *
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getData(Closure $callback, string $key): string
    {
        $data = $this->cache->get($key);
        if (null === $data) {
            $data = $callback();

            $this->cache->set($key, $data, self::CACHE_TTL);

            return $data;
        }

        return $data;
    }

    /**
     * @param string $url
     * @param array  $parameters
     *
     * @return string
     */
    protected function assembleCacheKey(string $url, array $parameters): string
    {
        return md5(
            sprintf(
                '%s-%s-%s',
                $this->cachePrefix,
                $url,
                Utils::jsonEncode($parameters)
            )
        );
    }
}
