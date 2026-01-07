<?php
session_start();
include "config/db.php";

// Pastikan user login
//if (!isset($_SESSION['customer_id'])) {
    //die("Anda harus login sebelum checkout.");
//}

// Pastikan keranjang ada
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    die("Keranjang masih kosong.");
}

$customer_id = $_SESSION['customer_id'];
$address_id = $_POST['address_id'];
$shipping = $_POST['shipping'];

// Hitung total
$total_price = 0;
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM products WHERE id=$product_id"));
    $total_price += $p['price'] * $qty;
}

// Simpan ke tabel orders
$queryOrder = "
    INSERT INTO orders (customer_id, address_id, shipping_method, total_price, status, created_at)
    VALUES ($customer_id, $address_id, '$shipping', $total_price, 'pending', NOW())
";

mysqli_query($conn, $queryOrder);
$order_id = mysqli_insert_id($conn);

// Simpan item ke order_items
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM products WHERE id=$product_id"));
    $price = $p['price'];

    mysqli_query($conn, "
        INSERT INTO order_items (order_id, product_variant_id, quantity, price)
        VALUES ($order_id, $product_id, $qty, $price)
    ");
}

// Bersihkan keranjang
unset($_SESSION['cart']);

header("Location: checkout_success.php?id=".$order_id);
exit();
?>
