CREATE DATABASE smartpay;
USE smartpay;


CREATE TABLE customer (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL
);


CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    amount FLOAT NOT NULL,
    status VARCHAR(20) NOT NULL,
    order_date DATE NOT NULL,
    customer_id INT NOT NULL,
    FOREIGN KEY (customer_id)
        REFERENCES customer(customer_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);


CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    amount FLOAT NOT NULL,
    status VARCHAR(20) NOT NULL,
    payment_date DATE NOT NULL,
    payment_type VARCHAR(20) NOT NULL,
    orders_id INT NOT NULL,
    FOREIGN KEY (orders_id)
        REFERENCES orders(order_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);


CREATE TABLE send_payment (
    payments_id INT PRIMARY KEY,
    FOREIGN KEY(payments_id) REFERENCES payments(id)
);


CREATE TABLE paypal (
    payments_id INT PRIMARY KEY,
    FOREIGN KEY(payments_id) REFERENCES payments(id)
);


CREATE TABLE bank_card (
    payments_id INT PRIMARY KEY,
    FOREIGN KEY(payments_id) REFERENCES payments(id)
);
