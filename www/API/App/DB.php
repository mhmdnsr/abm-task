<?php

namespace App;

use PDO;
use App\Config;

final class DB
{
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new DB();
        }
        return self::getDB();
    }

    private function __construct()
    {
        self::startDBConnection();
    }


    private static $db = null;

    private static function getDB()
    {
        return self::$db;
    }

    private static function setDB($db)
    {
        self::$db = $db;
    }

    private static function startDBConnection()
    {
        if (self::getDB() !== null)
            return;

        $dsn = 'mysql:host=' . Config::DB_HOST .
            ';dbname=' . Config::DB_NAME . ';charset=utf8';
        $db = new PDO(
            $dsn,
            Config::DB_USER,
            Config::DB_PASSWORD,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8")
        );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::setDB($db);
    }
}