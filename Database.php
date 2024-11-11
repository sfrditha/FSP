<?php
class Database {
    private $host = "localhost:3306";
    private $username = "root";
    private $password = "";
    private $database = "esport";
    public $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_errno) {
            die("Koneksi ke Database Failed: " . $this->connection->connect_errno);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection->close();
    }
}
?>
