<?php
include "../../config/db.php";

// Total pendapatan
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) AS total_income FROM orders"));

// Pendapatan harian
$today = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) AS today_income FROM orders WHERE DATE(created_at) = CURDATE()"));

// Pendapatan bulanan
$month = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) AS month_income FROM orders WHERE MONTH(created_at) = MONTH(CURDATE())"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: Arial; background: #eef2f3; padding: 20px; }
        .container {
            max-width: 700px; margin: auto; background: #fff;
            padding: 25px; border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; margin-bottom: 20px; }
        .card {
            background: #f5f5f5; padding: 15px;
            border-radius: 10px; margin-bottom: 15px;
        }
        .btn {
            background: #007bff; color: #fff; padding: 10px 15px;
            text-decoration: none; border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Laporan Keuangan</h2>

    <div class="card">
        <h3>Pendapatan Hari Ini</h3>
        <p>Rp <?= number_format($today['today_income'] ?? 0, 0, ',', '.'); ?></p>
    </div>

    <div class="card">
        <h3>Pendapatan Bulan Ini</h3>
        <p>Rp <?= number_format($month['month_income'] ?? 0, 0, ',', '.'); ?></p>
    </div>

    <div class="card">
        <h3>Total Pendapatan</h3>
        <p>Rp <?= number_format($total['total_income'] ?? 0, 0, ',', '.'); ?></p>
    </div>

    <br>
    <a class="btn" href="sales.php">← Kembali</a>

</div>

</body>
</html>
