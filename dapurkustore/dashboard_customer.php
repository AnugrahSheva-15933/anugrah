<?php
session_start();
include "config/db.php";

// ✅ Cek apakah customer sudah login
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID customer dari session
$customer_id = $_SESSION['customer_id'];

// Ambil data customer dengan prepared statement (lebih aman)
$stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$cust = $result->fetch_assoc();

// Jika customer tidak ditemukan (misal dihapus dari DB)
if (!$cust) {
    // Logout dan redirect
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Customer | Dapurku Store</title>
<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    margin: 0;
}
.header {
    background: #0984e3;
    color: #fff;
    padding: 15px 20px;
}
.container {
    padding: 20px;
}
.card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    margin-bottom: 15px;
}
a.btn {
    display: inline-block;
    padding: 10px 15px;
    background: #0984e3;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    margin-right: 10px;
}
a.logout {
    background: #d63031;
}
</style>
</head>
<body>

<div class="header">
    <h2>🍳 Dapurku Store</h2>
</div>

<div class="container">

    <div class="card">
        <h3>Halo, <?= htmlspecialchars($cust['username']); ?> 👋</h3>
        <p>Selamat datang di Dapurku Store</p>
    </div>

    <div class="card">
        <a class="btn" href="product_list.php">🛒 Belanja Produk</a>
        <a class="btn" href="cart.php">📦 Pesanan Saya</a>
        <a class="btn logout" href="logout.php">🚪 Logout</a>
    </div>

</div>

</body>
</html>
