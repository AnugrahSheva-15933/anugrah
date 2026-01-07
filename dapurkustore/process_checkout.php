<?php
session_start();
include "config/db.php";

/* ==========================
   VALIDASI DASAR
========================== */

// Wajib login
if (!isset($_SESSION['customer_id'])) {
    die("Anda harus login sebelum checkout.");
}

// Keranjang tidak boleh kosong
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    die("Keranjang masih kosong.");
}

$customer_id = (int) $_SESSION['customer_id'];
$address_id  = (int) $_POST['address'];
$shipping    = mysqli_real_escape_string($conn, $_POST['shipping']);

/* ==========================
   TRANSAKSI DATABASE
========================== */

$conn->begin_transaction();

try {

    // HITUNG TOTAL + CEK STOK
    $total_price = 0;

    foreach ($_SESSION['cart'] as $product_id => $qty) {

        $stmt = $conn->prepare(
            "SELECT price, stock FROM products WHERE id = ?"
        );
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if (!$product) {
            throw new Exception("Produk tidak ditemukan.");
        }

        if ($qty > $product['stock']) {
            throw new Exception("Stok produk tidak mencukupi.");
        }

        $total_price += $product['price'] * $qty;
    }

    // SIMPAN ORDER
    $stmt = $conn->prepare("
        INSERT INTO orders
        (customer_id, address, shipping, total, status, created_at)
        VALUES (?, ?, ?, ?, 'pending', NOW())
    ");
    $stmt->bind_param(
        "iisd",
        $customer_id,
        $address,
        $shipping,
        $total
    );
    $stmt->execute();

    $order_id = $stmt->insert_id;

    // SIMPAN ORDER ITEMS + KURANGI STOK
    foreach ($_SESSION['cart'] as $product_id => $qty) {

        $stmt = $conn->prepare(
            "SELECT price FROM products WHERE id = ?"
        );
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        $price = $product['price'];

        // Jika TIDAK ADA VARIAN PRODUK → ganti kolom
        $stmt = $conn->prepare("
            INSERT INTO order_items
            (order_id, product_id, qty, price)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "iiid",
            $order_id,
            $product_id,
            $qty,
            $price
        );
        $stmt->execute();

        // Kurangi stok
        $stmt = $conn->prepare(
            "UPDATE products SET stock = stock - ? WHERE id = ?"
        );
        $stmt->bind_param("ii", $qty, $product_id);
        $stmt->execute();
    }

    // SEMUA AMAN
    $conn->commit();

    unset($_SESSION['cart']);
    header("Location: checkout_success.php?id=" . $order_id);
    exit();

} catch (Exception $e) {

    // GAGAL → ROLLBACK
    $conn->rollback();
    die("Checkout gagal: " . $e->getMessage());
}
