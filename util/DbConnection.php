<?php

namespace util;

use PDO;
use PDOException;

class DbConnection
{

    private static ?DbConnection $dbConnection = null;
    private PDO $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=bhmey0osw1vahfdxpof4-mysql.services.clever-cloud.com;port=3306;dbname=bhmey0osw1vahfdxpof4", "u0xzt4e8w2dhm45o", "BkAxbTUzUTyhvPM8JOBM");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function getInstance(): ?DbConnection
    {
        if (!isset(self::$dbConnection)){
            return self::$dbConnection = new DbConnection();
        }

        return self::$dbConnection;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

}