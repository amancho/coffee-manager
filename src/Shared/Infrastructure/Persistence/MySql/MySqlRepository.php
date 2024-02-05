<?php

namespace App\Shared\Infrastructure\Persistence\MySql;

use PDO;
use PDOException;

final class MySqlRepository extends PDO
{
    private static $pdo;

    public function __construct(string $dsn, ?string $username = null, ?string $password = null, ?array $options = null)
    {
        parent::__construct($dsn, $username, $password, $options);
    }

    public static function getClient(): PDO
    {
        if (!(self::$pdo instanceof PDO)) {
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $dsn = "mysql:host=coffee-machine.mysql;dbname=coffee_machine;charset=utf8";
            try {
                self::$pdo = new PDO($dsn, 'coffee_machine', 'coffee_machine', $options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$pdo;
    }
}