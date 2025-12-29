<?php


require_once __DIR__ . '/../database/Database.php';

class Client {
    private $id;
    private $name;
    private $email;

    private $conn;

    public function __construct($name, $email, $id = null) {
        $this->name = $name;
        $this->email = $email;
        $this->id = $id;

        $db = new Database();
        $this->conn = $db->connect();
    }

    
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }

    public function setName($name) { $this->name = $name; }
    public function setEmail($email) { $this->email = $email; }

   
    public function save() {
        $stmt = $this->conn->prepare("INSERT INTO customer (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $this->name, 'email' => $this->email]);
        $this->id = $this->conn->lastInsertId();
    }

  
    public static function getAll() {
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->query("SELECT * FROM customer");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
