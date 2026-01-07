<?php
include "../../config/db.php";

// Ambil semua order
$data = mysqli_query($conn, "SELECT * FROM orders ORDER BY created_at DESC");

// Hitung total pendapatan
$total_result = mysqli_query($conn, "SELECT SUM(total) AS total_income FROM orders");
$total = mysqli_fetch_assoc($total_result)['total_income'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; padding:20px; }
        h2 { text-align:center; margin-bottom:25px; }
        .card {
            background:#fff; padding:20px; border-radius:10px;
            box-shadow:0 3px 10px rgba(0,0,0,0.1); margin-bottom:20px;
            max-width: 900px; margin:auto;
        }
        table { width:100%; border-collapse: collapse; margin-top:15px; }
        th, td { padding:12px; text-align:left; border-bottom:1px solid #eee; }
        th { background:#007bff; color:#fff; }
        tr:hover { background:#f1f1f1; }
        .total-box {
            background:#28a745; color:#fff; padding:15px; 
            text-align:center; border-radius:8px; margin-bottom:20px;
            font-size:18px; font-weight:bold;
        }
    </style>
</head>

<body>

<div class="card">
    <h2>Laporan Penjualan</h2>

    <div class="total-box">
        Total Pendapatan: Rp <?= number_format($total, 0, ',', '.'); ?>
    </div>

    <table>
        <tr>
            <th>ID Order</th>
            <th>Tanggal</th>
            <th>Total (Rp)</th>
        </tr>

        <?php while ($s = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $s['id']; ?></td>
            <td><?= date("d M Y H:i", strtotime($s['created_at'])); ?></td>
            <td><?= number_format($s['total'], 0, ',', '.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
