<?php

class Env {

    public static function load($path) {

        if (!file_exists($path)) {
            die(".env file not found");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {

            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            [$key, $value] = explode("=", $line, 2);

            $key = trim($key);
            $value = trim($value);

            // supprimer guillemets
            $value = trim($value, "\"'");

            $_ENV[$key] = $value;
        }
    }
}