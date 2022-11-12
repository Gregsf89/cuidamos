<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use stdClass;

/**
 * Class JwtHelper
 * @package App\Helpers
 */
class JwtHelper
{
    public static array $config = [];

    /**
     * Build an JWT token
     *
     * @param array $tokenInfo The information to be attached on the token.
     * @return string An JWT token based on given info.
     */
    public static function buildToken(array $tokenInfo): string
    {
        if (empty(self::$config)) {
            self::setConfig();
        }

        $startTime = time();
        $token = array(
            'iss' => self::$config['app_url'],
            'iat' => $startTime,
            'exp' => $startTime + self::$config['ttl'],
            'nbf' => $startTime
        );

        $token = array_merge(
            $tokenInfo,
            $token
        );

        return JWT::encode($token, self::$config['secret'], self::$config['algo']);
    }

    /**
     * Decodes an JWT token
     *
     * @param string $token The token to be decoded.
     * @return stdClass An associative array with the token information
     */
    public static function decodeToken(string $token): stdClass
    {
        return JWT::decode($token, self::$config['secret'], [self::$config['algo']]);
    }

    public static function setConfig(): void
    {
        self::$config = config('jwt', []);
    }
}
