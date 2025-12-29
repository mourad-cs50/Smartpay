<?php
// classes/Virement.php

require_once 'Paiement.php';

class Virement extends Paiement {

    public function payer() {
        $stmt = $this->conn->prepare(
            "INSERT INTO payments (amount, status, payment_date, payment_type, orders_id)
             VALUES (:amount, :status, :payment_date, :payment_type, :orders_id)"
        );
        $stmt->execute([
            'amount' => $this->amount,
            'status' => 'PAYÉ',
            'payment_date' => $this->payment_date,
            'payment_type' => 'Virement',
            'orders_id' => $this->orders_id
        ]);
        $this->id = $this->conn->lastInsertId();

        $stmt2 = $this->conn->prepare("INSERT INTO send_payment (payments_id) VALUES (:id)");
        $stmt2->execute(['id' => $this->id]);

        $stmt3 = $this->conn->prepare("UPDATE orders SET status='PAYÉ' WHERE order_id=:id");
        $stmt3->execute(['id' => $this->orders_id]);

        echo "virement pay with succes\n";
    }
}
