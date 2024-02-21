<?php

namespace Ngotr\Thithu1\Commons;

use PDOException;

class Model
{
    protected \PDO|null $conn;
    public function __construct()
    {
        $host = DB_HOST;
        $port = DB_PORT;
        $dbname = DB_NAME;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;

        try {
            $this->conn = new \PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password); // Sử dụng $this->conn thay vì $conn

            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (PDOException $PDOException) {
            echo "Kết nối thất bại: " . $PDOException->getMessage();
            die;
        }

    }
    public function __destruct()
    {
        $this->conn = null;
    }
}
