<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'quotesdb';
    private $username = 'postgres';
    private $password = 'Hholuska1!';
    private $conn;
    //Connection
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                'pgsql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}