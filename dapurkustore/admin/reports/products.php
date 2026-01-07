<?php
include "../../config/db.php";

// Query produk terlaris
$query = "
    SELECT p.name, SUM(od.quantity) AS total_qty
    FROM order_details od
    JOIN products p ON od.product_id = p.id
    GROUP BY p.id
    ORDER BY total_qty DESC
";

$data = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
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

    <h2>Produk Terlaris</h2>

    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Jumlah Terjual</th>
        </tr>

        <?php while ($p = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $p['name']; ?></td>
            <td><?= $p['total_qty'] ?? 0; ?></td>
        </tr>
        <?php endwhile; ?>

    </table>

    <br>
    <a class="btn" href="index.php">← Kembali</a>

</div>

</body>
</html>
