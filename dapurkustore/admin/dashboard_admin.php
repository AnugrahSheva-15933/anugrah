<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin | Dapurku Store</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f1f2f6;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: #0984e3;
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
        background: #74b9ff;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        transition: 0.3s;
        font-weight: bold;
    }

    .sidebar a:hover {
        background: #dfe6e9;
        color: #0984e3;
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
    <h2>Dapurku Store</h2>

    <a href="products/products.php">Kelola Produk</a>
    <a href="orders/orders.php">Kelola Pesanan</a>
    <a href="vouchers/vouchers.php">Kelola Voucher</a>
    <a href="reports/sales.php">Laporan Penjualan</a>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="content">
    <h1>Dashboard Admin</h1>

    <div class="card">
        <h3>Selamat Datang di Admin Panel Dapurku Store</h3>
        <p>
            Kelola produk alat dapur, pesanan pelanggan, voucher promo,  
            dan laporan penjualan toko Anda di sini.
        </p>
    </div>

</div>

</body>
</html>
