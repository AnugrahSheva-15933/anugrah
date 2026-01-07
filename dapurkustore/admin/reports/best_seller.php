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
JOIN products p ON oi.product_variant_id = p.id
GROUP BY oi.product_variant_id
ORDER BY total_qty DESC
";

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produk Terlaris</title>
    <style>
        body { font-family: Arial, sans-serif; background:#eef1f5; padding:20px;}
        h2 { text-align:center; }
        .card {
            background:#fff; padding:20px; border-radius:10px;
            max-width:900px; margin:auto;
            box-shadow:0 3px 10px rgba(0,0,0,0.1);
        }
        table { width:100%; border-collapse: collapse; margin-top:15px;}
        th, td { padding:12px; border-bottom:1px solid #ddd; }
        th { background:#17a2b8; color:#fff; }
        tr:hover { background:#f7f7f7; }
    </style>
</head>

<body>

<div class="card">
    <h2>Produk Terlaris</h2>

    <table>
        <tr>
            <th>Produk</th>
            <th>Harga (Rp)</th>
            <th>Total Terjual</th>
        </tr>

        <?php while ($p = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $p['name']; ?></td>
            <td><?= number_format($p['price'], 0, ',', '.'); ?></td>
            <td><?= $p['total_qty']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>