<?php
try {
    $db = new PDO('sqlite:shop.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id       INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        role     TEXT NOT NULL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS products (
        id    INTEGER PRIMARY KEY AUTOINCREMENT,
        name  TEXT NOT NULL,
        price REAL NOT NULL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS orders (
        id           INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id      INTEGER NOT NULL,
        username     TEXT NOT NULL,
        product_name TEXT NOT NULL,
        quantity     INTEGER NOT NULL,
        total        REAL NOT NULL,
        ordered_at   TEXT DEFAULT (datetime('now','localtime'))
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
