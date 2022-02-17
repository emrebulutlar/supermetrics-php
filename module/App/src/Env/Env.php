<?php

namespace App\Env;

class Env
{

    /**
     * @return bool
     */
    public static function isLocal(): bool
    {
        return isset($_ENV["APP_ENV"]) && $_ENV["APP_ENV"] === 'local';
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public static function get(string $key): mixed
    {
        return $_ENV[$key] ?? null;
    }
}
