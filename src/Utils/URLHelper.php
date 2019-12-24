<?php


namespace App\Utils;


class URLHelper
{
    /**
     * @param string $path
     * @return string
     */
    public static function encodeURL(string $path): string
    {
        $path = ltrim($path, '/');

        return '/'.urlencode($path);
    }

    /**
     * @param string $path
     * @return string
     */
    public static function decodeURL(string $path): string
    {
        $path = ltrim($path, '/');

        return '/'.urldecode($path);
    }
}
