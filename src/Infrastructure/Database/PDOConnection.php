<?php

namespace Fulll\Infrastructure\Database;

use PDO;

class PDOConnection
{
    /** @var PDO  */
    private PDO $pdo;

    /** @var $this|null  */
    private static ?self $instance = null;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8', $_ENV['DB_USER'], $_ENV['DB_PASS']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo->exec('SET NAMES UTF8');
    }

    /**
     * @return PDO
     */
    public static function getPdo(): PDO
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance->pdo;
    }
}
