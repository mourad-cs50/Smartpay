<?php
require_once 'classes/Client.php';
require_once 'classes/Commande.php';
require_once 'classes/CarteBancaire.php';
require_once 'classes/Paypal.php';
require_once 'classes/Virement.php';

while (true) {
    echo "==============================\n";
    echo " PAYMENT SYSTEM - MENU\n";
    echo "==============================\n";
    echo "1. Create a client\n";
    echo "2. Create an order\n";
    echo "3. Pay an order\n";
    echo "4. Show orders\n";
    echo "0. Exit\n";
    echo "------------------------------\n";
    $choice = readline("Your choice: ");

    switch ($choice) {
        case 1:
            $name = readline("Client name: ");
            $email = readline("Client email: ");
            $client = new Client($name, $email);
            $client->save();
            echo "Client created successfully\n";
            break;

        case 2:
            $clients = Client::getAll();
            foreach ($clients as $c) {
                echo "{$c['customer_id']} - {$c['name']} ({$c['email']})\n";
            }
            $cid = readline("Client ID: ");
            $amount = readline("Amount: ");
            $commande = new Commande($amount, "EN_ATTENTE", $cid);
            $commande->save();
            echo "Order created successfully\n";
            break;

        case 3:
            $orders = Commande::getPending();
            foreach ($orders as $o) {
                echo "{$o['order_id']} - Amount: {$o['amount']} - Status: {$o['status']}\n";
            }
            $oid = readline("Order ID: ");
            echo "Choose payment method:\n1- Bank Card\n2- Paypal\n3- Bank Transfer\n";
            $payChoice = readline("Your choice: ");
            $orderAmount = 0;
            foreach ($orders as $o) {
                if ($o['order_id'] == $oid) {
                    $orderAmount = $o['amount'];
                    break;
                }
            }
            if ($payChoice == 1) $payment = new CarteBancaire($orderAmount, $oid);
            elseif ($payChoice == 2) $payment = new Paypal($orderAmount, $oid);
            elseif ($payChoice == 3) $payment = new Virement($orderAmount, $oid);
            else { echo "Invalid choice\n"; break; }
            $payment->payer();
            break;

        case 4:
            $orders = Commande::getAll();
            foreach ($orders as $o) {
                echo "Order ID: {$o['order_id']}, Amount: {$o['amount']}, Status: {$o['status']}, Customer ID: {$o['customer_id']}\n";
            }
            break;

        case 0:
            echo "Exiting...\n";
            exit;

        default:
            echo "Invalid option!\n";
            break;
    }
}
