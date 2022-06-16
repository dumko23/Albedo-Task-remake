<?php

namespace App\core\database;

use PDO;
use PDOException;

class PDOClass
{
    private static PDO $db;

    public static function connection($config): PDO
    {
        if (!isset(self::$db)) {
            self::$db = new PDO($config['name'] . 'dbname:' . $config['db'],
                $config['user'], $config['password'], $config['options']);
        }
        return self::$db;
    }

    /**
     * @return PDO
     */
    public static function getDb(): PDO
    {
        return self::$db;
    }
}