<?php
class DataBase
{
    private $host = "mysql";
    private $dbname = "gamelibrary";
    private $username = "root";
    private $password = "root";
    private $conn;

    function __construct()
    {

        //connect to the database
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}