<?php


require_once __DIR__ . '/../database/Database.php';

abstract class Paiement {
    protected $id;
    protected $amount;
    protected $status;
    protected $payment_date;
    protected $orders_id;

    protected $conn;

    public function __construct($amount, $orders_id, $status = 'EN_ATTENTE', $payment_date = null, $id = null) {
        $this->amount = $amount;
        $this->orders_id = $orders_id;
        $this->status = $status;
        $this->payment_date = $payment_date ?? date('Y-m-d');
        $this->id = $id;

        $db = new Database();
        $this->conn = $db->connect();
    }

    abstract public function payer();
}
