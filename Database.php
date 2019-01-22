<?php
include_once 'Config.php';
include_once 'Shorter.php';

class Database
{
    private static $connection;

    /**
     * @param string $url
     * @return string
     */
    public static function saveUrl($url)
    {
        if ($url) {
            try {
                self::connect();

                $fullUrlQuote = self::$connection->quote($url);

                $sql = "SELECT short_url FROM " . Config::DATABASE_NAME . ".urls WHERE full_url = $fullUrlQuote LIMIT 1";

                $result = self::$connection->query($sql);
                $data = $result->fetch();

                if ($data !== false) {
                    return Config::SERVER_NAME . "/{$data['short_url']}";
                }

                $sql = "SELECT MAX(id) FROM " . Config::DATABASE_NAME . ".urls";

                $maxId = self::$connection->query($sql)->fetch();
                $nextId = $maxId[0] + 1;

                $shortUrl = Shorter::createShortUrl($nextId);

                $shortUrlQuote = self::$connection->quote($shortUrl);

                $sql = "INSERT INTO " . Config::DATABASE_NAME . ".urls (`full_url`, `short_url`) VALUES ($fullUrlQuote, $shortUrlQuote)";
                self::$connection->exec($sql);

                return Config::SERVER_NAME . "/$shortUrl";
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return '';
    }

    /**
     * @param string $shortUrl
     * @return string
     */
    public static function getFullUrl($shortUrl)
    {
        if ($shortUrl) {
            try {
                self::connect();

                $shortUrlQuote = self::$connection->quote($shortUrl);

                $sql = "SELECT full_url FROM " . Config::DATABASE_NAME . ".urls WHERE short_url = $shortUrlQuote LIMIT 1";

                $result = self::$connection->query($sql);
                $data = $result->fetch();

                if ($data !== false) {
                    return $data['full_url'];
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return '';
    }

    private static function connect()
    {
        try {
            self::$connection = new PDO("mysql:host = " . Config::SERVER_NAME . "; dbname = " . Config::DATABASE_NAME,
                Config::DATABASE_USERNAME, Config::DATABASE_PASSWORD);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE DATABASE IF NOT EXISTS " . Config::DATABASE_NAME;

            self::$connection->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS " . Config::DATABASE_NAME . ".`urls` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `full_url` VARCHAR(1000) NOT NULL,
                `short_url` VARCHAR(50) NOT NULL,
                PRIMARY KEY (`id`)
            );";

            self::$connection->exec($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}