<?php

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private static ?PDO $pdo = null;

    private function __construct() {}
    private function __clone() {}

    public static function getPdo(): PDO
    {
        // Singleton : si déjà créé, on réutilise
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $host = 'localhost';
        $db   = 'blogpoo';
        $user = 'root';
        $pass = '';
        $port = 3306;
        $charset = 'utf8';

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;port=%d;charset=%s',
            $host,
            $db,
            $port,
            $charset
        );
        try {
            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException("Impossible de se connecter à la base de données.");
        }

        return self::$pdo;
    }
}
