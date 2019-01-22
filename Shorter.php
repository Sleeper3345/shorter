<?php

class Shorter
{
    /**
     * @param int $id
     * @return string
     */
    public static function createShortUrl($id)
    {
        $shortUrl = '';

        if ($id > 0) {
            $base = 62;
            $input = 150185710 + $id;
            $output = '';

            $dictionary = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

            while ($input > 0) {
                $digit = $input % $base;
                $output = $dictionary[$digit] . $output;
                $input = (int)($input / $base);
            }

            $shortUrl = $output;
        }

        return $shortUrl;
    }
}
