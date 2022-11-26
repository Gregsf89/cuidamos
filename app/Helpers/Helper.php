<?php

namespace App\Helpers;

use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Error;
use Exception;

/**
 * Class Helper
 * @package App\Helpers
 */
class Helper
{
    /**
     * Returns a random string
     * 
     * @param int $length
     * @return string
     */
    static function generateRandomString($length = 13): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Returns a random string
     * 
     * @param int $length
     * @return string
     */
    static function generateRandomPhoneToken(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
