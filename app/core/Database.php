<?php
namespace App\Core;

class Database {
    private $pdo;

    public function __construct($pdo = null) {
        if ($pdo) {
            $this->pdo = $pdo;
        } else {
            $dsn = "pgsql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'];
            $this->pdo = new \PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }
}
