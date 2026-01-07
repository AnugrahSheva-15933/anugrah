<?php 
session_start(); 
// Cek login admin
//if (!isset($_SESSION['admin'])) {
    //header("Location: login.php");
    //exit;
//}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f6fa;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: #2d3436;
        color: #fff;
        position: fixed;
        padding: 30px 20px;
    }

    .sidebar h2 {
        margin-bottom: 40px;
        font-size: 22px;
        text-align: center;
        letter-spacing: 1px;
    }

    .sidebar a {
        display: block;
        padding: 12px 15px;
        margin: 10px 0;
        background: #636e72;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background: #00cec9;
    }

    .content {
        margin-left: 270px;
        padding: 40px;
    }

    .card {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    h1 {
        margin-top: 0;
        font-size: 28px;
        color: #2d3436;
    }

    .logout {
        position: absolute;
        bottom: 20px;
        left: 20px;
        width: 210px;
        text-align: center;
    }

    .logout a {
        background: #d63031;
        display: block;
        padding: 12px;
        color: #fff;
        border-radius: 6px;
        text-decoration: none;
    }

    .logout a:hover {
        background: #ff7675;
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>

    <a href="products/index.php">Kelola Produk</a>
    <a href="orders/index.php">Kelola Pesanan</a>
    <a href="vouchers/index.php">Kelola Voucher</a>
    <a href="reports/sales.php">Laporan Penjualan</a>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="content">
    <h1>Welcome, Admin</h1>
    <div class="card">
        <h3>Selamat datang di Dashboard Sikil Resik</h3>
        <p>Gunakan menu di sebelah kiri untuk mengelola toko online Anda.</p>
    </div>

</div>

</body>
</html>
