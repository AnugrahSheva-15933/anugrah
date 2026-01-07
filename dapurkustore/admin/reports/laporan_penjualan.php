<?php
include "../../config/db.php";

// Ambil order PAID saja
$data = mysqli_query($conn, "
    SELECT * FROM orders 
    WHERE status = 'Paid'
    ORDER BY created_at DESC
");$total_result = mysqli_query($conn, "


// Hitung total pendapatan (PAID)
    SELECT SUM(total) AS total_income 
    FROM orders 
    WHERE status = 'Paid'
");

$total = mysqli_fetch_assoc($total_result)['total_income'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - Dapurku Store</title>

    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; padding:20px; }
        h2 { text-align:center; margin-bottom:25px; }
        .card {
            background:#fff; padding:20px; border-radius:10px;
            box-shadow:0 3px 10px rgba(0,0,0,0.1); margin:auto;
            max-width:900px;
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
    <h2>📊 Laporan Penjualan</h2>

    <div class="total-box">
        Total Pendapatan: Rp <?= number_format($total, 0, ',', '.'); ?>
    </div>

    <table>
        <tr>
            <th>ID Order</th>
            <th>Tanggal</th>
            <th>Total (Rp)</th>
        </tr>

        <?php if (mysqli_num_rows($data) > 0): ?>
            <?php while ($s = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td>#<?= $s['id']; ?></td>
                <td><?= date("d M Y H:i", strtotime($s['created_at'])); ?></td>
                <td>Rp <?= number_format($s['total'], 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" style="text-align:center;">Belum ada penjualan</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
