<?php

class Database
{
    protected static ?PDO $connection = null;

    private function __construct()
    {
        $jsonPath = __DIR__ . '/../Resource/Config/database.json';
        $jsonContent = json_decode(file_get_contents($jsonPath), true);

        try {
            self::$connection = new \PDO(
                'mysql:host=' . $jsonContent['host'] . ';dbname=' . $jsonContent['dbname'],
                $jsonContent['username'],
                $jsonContent['password'],
                $jsonContent['options']
            );
        } catch (\PDOException $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            new self();
        }

        return self::$connection;
    }
}
