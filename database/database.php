<?php

class Database {
    private $host = "localhost";
    private $db_name = "smrt";
    private $username = "root";
    private $password = "";
    private $port =  "3308";   
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};port={$this->port}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "no connection" . $e->getMessage();
            exit;
        }
        return $this->conn;
    }
}
