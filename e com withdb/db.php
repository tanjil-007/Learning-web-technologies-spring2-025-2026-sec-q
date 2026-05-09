<?php
try {
    $db = new PDO("mysql:host=localhost;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("CREATE DATABASE IF NOT EXISTS shopdb");
    $db->exec("USE shopdb");

    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id       INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role     VARCHAR(20) NOT NULL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS products (
        id    INT AUTO_INCREMENT PRIMARY KEY,
        name  VARCHAR(100) NOT NULL,
        price DECIMAL(10,2) NOT NULL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS orders (
        id           INT AUTO_INCREMENT PRIMARY KEY,
        user_id      INT NOT NULL,
        username     VARCHAR(100) NOT NULL,
        product_name VARCHAR(100) NOT NULL,
        quantity     INT NOT NULL,
        total        DECIMAL(10,2) NOT NULL,
        ordered_at   DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $check = $db->query("SELECT id FROM users WHERE username='admin'")->fetch();
    if (!$check) {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $db->exec("INSERT INTO users (username,password,role) VALUES ('admin','$hash','admin')");
    }

    $check = $db->query("SELECT id FROM users WHERE username='customer1'")->fetch();
    if (!$check) {
        $hash = password_hash('pass123', PASSWORD_DEFAULT);
        $db->exec("INSERT INTO users (username,password,role) VALUES ('customer1','$hash','customer')");
    }

    $check = $db->query("SELECT id FROM products")->fetch();
    if (!$check) {
        $db->exec("INSERT INTO products (name,price) VALUES
            ('T-Shirt',499),('Jeans',1299),('Sneakers',2499),
            ('Cap',349),('Jacket',1999),('Polo Shirt',799)
        ");
    }

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
?>
