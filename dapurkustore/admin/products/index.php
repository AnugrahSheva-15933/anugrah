<?php
include "../../config/db.php";
$data = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            margin: 0; padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-add {
            display: inline-block;
            background: #007bff;
            color: #fff;
            padding: 10px 14px;
            border-radius: 6px;
            text-decoration: none;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            padding: 12px 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        table tr:hover {
            background: #f2f2f2;
        }
        .btn-edit {
            background: #28a745;
            padding: 6px 10px;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-delete {
            background: #dc3545;
            padding: 6px 10px;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manajemen Produk</h2>

    <a class="btn-add" href="add.php">+ Tambah Produk</a>

    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php while ($p = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $p['name']; ?></td>
            <td>Rp <?= number_format($p['price'], 0, ',', '.'); ?></td>
            <td><?= $p['stock']; ?></td>
            <td>
                <a class="btn-edit" href="edit.php?id=<?= $p['id']; ?>">Edit</a>
                <a class="btn-delete" onclick="return confirm('Yakin hapus produk ini?');" 
                   href="delete.php?id=<?= $p['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>

</body>
</html>
