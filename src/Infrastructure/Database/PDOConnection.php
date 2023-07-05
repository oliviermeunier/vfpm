<?php

namespace Fulll\Infrastructure\Database;

use PDO;

class PDOConnection
{
    private PDO $pdo;
    private static ?self $instance = null;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8', $_ENV['DB_USER'], $_ENV['DB_PASS']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo->exec('SET NAMES UTF8');
    }

    public static function getPdo(): PDO
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance->pdo;
    }
}
