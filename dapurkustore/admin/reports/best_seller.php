<?php
include "../../config/db.php";

$query = "
SELECT 
    p.id,
    p.name,
    p.price,
    SUM(oi.quantity) AS total_qty,
    SUM(oi.quantity * oi.price) AS total_sales
FROM order_items oi
JOIN orders o ON oi.order_id = o.id
JOIN products p ON oi.product_variant_id = p.id
WHERE o.status = 'Paid'
GROUP BY p.id
ORDER BY total_qty DESC
";

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk Terlaris</title>

    <style>
        body { font-family: Arial; background: #eef2f3; padding: 20px; }
        .container {
            max-width: 900px; margin: auto; background: #fff;
            padding: 25px; border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            padding: 12px; border-bottom: 1px solid #ddd;
        }
        th { background: #28a745; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn {
            background: #007bff; color: #fff; padding: 10px 15px;
            text-decoration: none; border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>🔥 Produk Terlaris</h2>

    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Total Terjual</th>
        </tr>

        <?php if (mysqli_num_rows($data) > 0): ?>
            <?php while ($p = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $p['name']; ?></td>
                <td><?= number_format($p['total_qty'], 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" style="text-align:center;">Belum ada penjualan</td>
            </tr>
        <?php endif; ?>
    </table>

    <br>
    <a class="btn" href="index.php">← Kembali</a>

</div>

</body>
</html>
