<?php
include "../../config/db.php";

// HANYA ORDER YANG SUDAH DIBAYAR
$data = mysqli_query($conn, "
    SELECT id, total_price, created_at
    FROM orders
    WHERE status = 'Paid'
    ORDER BY created_at DESC
");

// HITUNG TOTAL OMZET
$totalOmzet = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - Dapurku Store</title>

    <style>
        body { font-family: Arial; background: #eef2f3; padding: 20px; }
        .container {
            max-width: 900px; margin: auto; background: #fff;
            padding: 25px; border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        tr:hover { background: #f5f5f5; }
        .menu a {
            padding: 10px 15px; background: #007bff; color: #fff;
            text-decoration: none; border-radius: 6px; margin-right: 10px;
        }
        .total {
            text-align: right;
            font-size: 18px;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>📊 Laporan Penjualan</h2>

    <div class="menu">
        <a href="finance.php">💰 Laporan Keuangan</a>
        <a href="best_seller.php">🔥 Produk Terlaris</a>
    </div>

    <br>

    <table>
        <tr>
            <th>ID Order</th>
            <th>Tanggal</th>
            <th>Total</th>
        </tr>

        <?php while ($s = mysqli_fetch_assoc($data)): 
            $totalOmzet += $s['total_price'];
        ?>
        <tr>
            <td>#<?= $s['id']; ?></td>
            <td><?= date('d-m-Y H:i', strtotime($s['created_at'])); ?></td>
            <td>Rp <?= number_format($s['total_price'], 0, ',', '.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="total">
        Total Omzet: Rp <?= number_format($totalOmzet, 0, ',', '.'); ?>
    </div>

</div>

</body>
</html>
