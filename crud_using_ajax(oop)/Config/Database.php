<?php

namespace Config;

use PDO;
use PDOException;

class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "admin123";
    private $database = "PHP_CRUD";
    private $connection;

    public function connect() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->database}",
                $this->user,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Database connected successfully.<br>"; 
            return $this->connection;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}

?>
