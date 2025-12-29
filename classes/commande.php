<?php


require_once __DIR__ . '/Client.php';
require_once __DIR__ . '/../database/Database.php';

class Commande {
    private $id;
    private $amount;
    private $status;
    private $order_date;
    private $customer_id;

    private $conn;

    public function __construct($amount, $status, $customer_id, $order_date = null, $id = null) {
        $this->amount = $amount;
        $this->status = $status;
        $this->customer_id = $customer_id;
        $this->order_date = $order_date ?? date('Y-m-d');
        $this->id = $id;

        $db = new Database();
        $this->conn = $db->connect();
    }


    public function getId() { return $this->id; }
    public function getAmount() { return $this->amount; }
    public function getStatus() { return $this->status; }
    public function getCustomerId() { return $this->customer_id; }


    public function setAmount($amount) { $this->amount = $amount; }
    public function setStatus($status) { $this->status = $status; }

    public function save() {
        $stmt = $this->conn->prepare(
            "INSERT INTO orders (amount, status, order_date, customer_id) 
             VALUES (:amount, :status, :order_date, :customer_id)"
        );
        $stmt->execute([
            'amount' => $this->amount,
            'status' => $this->status,
            'order_date' => $this->order_date,
            'customer_id' => $this->customer_id
        ]);
        $this->id = $this->conn->lastInsertId();
    }

 
    public static function getAll() {
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public static function getPending() {
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->query("SELECT * FROM orders WHERE status='EN_ATTENTE'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
