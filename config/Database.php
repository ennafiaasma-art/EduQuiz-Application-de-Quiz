<?php

require_once __DIR__ . "/Env.php";

Env::load(__DIR__ . "/.env");

class DB {

    public static function connect() {

        try {

            $pdo = new PDO(
                "mysql:host=" . $_ENV['HOST'] . ";dbname=" . $_ENV['DBNAME'] . ";charset=utf8",
                $_ENV['DBUSER'],
                $_ENV['PASSWORD']
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }
}