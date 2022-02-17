<?php

namespace App\Env;

use const ENVIRONMENT;

class Env
{

    /**
     * @return bool
     */
    public static function isLocal(): bool
    {
        return ENVIRONMENT === 'development';
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
