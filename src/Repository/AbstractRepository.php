<?php

include_once __DIR__ . '/../Service/Database.php';

class AbstractRepository
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }
}