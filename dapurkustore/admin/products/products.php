<?php
include "../../config/db.php";

$data = mysqli_query($conn, "
    SELECT id, name, price, stock, image, created_at
    FROM products
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Produk - Dapurku Store</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f6f6f6;
            margin:0; padding:20px;
        }
        h2 {
            text-align:center;
            margin-bottom:25px;
        }
        .container {
            max-width:1100px;
            margin:auto;
            background:#fff;
            padding:20px;
            border-radius:12px;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-add {
            display:inline-block;
            background:#00b894;
            color:#fff;
            padding:10px 16px;
            border-radius:8px;
            text-decoration:none;
            margin-bottom:15px;
            font-weight:bold;
        }
        table {
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }
        th, td {
            padding:12px 10px;
            border-bottom:1px solid #ddd;
            vertical-align:middle;
        }
        tr:hover { background:#f9f9f9; }

        img {
            width:60px;
            height:60px;
            object-fit:cover;
            border-radius:6px;
        }

        .btn-edit {
            background:#0984e3;
            padding:6px 12px;
            color:#fff;
            border-radius:6px;
            text-decoration:none;
            margin-right:4px;
            font-size:14px;
        }
        .btn-delete {
            background:#d63031;
            padding:6px 12px;
            color:#fff;
            border-radius:6px;
            text-decoration:none;
            font-size:14px;
        }

        .empty {
            text-align:center;
            padding:30px;
            font-size:18px;
            color:#777;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>🍳 Manajemen Produk Dapurku Store</h2>

    <a class="btn-add" href="add.php">+ Tambah Produk</a>

    <table>
        <tr>
            <th>Gambar</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($data) == 0): ?>
            <tr>
                <td colspan="5" class="empty">Belum ada produk.</td>
            </tr>
        <?php endif; ?>

        <?php while ($p = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td>
                <?php if (!empty($p['image'])): ?>
                    <img src="../../uploads/<?= $p['image']; ?>">
                <?php else: ?>
                    <img src="https://via.placeholder.com/60?text=No+Image">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($p['name']); ?></td>
            <td>Rp <?= number_format($p['price'],0,',','.'); ?></td>
            <td><?= $p['stock']; ?></td>
            <td>
                <a class="btn-edit" href="edit.php?id=<?= $p['id']; ?>">Edit</a>
                <a class="btn-delete"
                   onclick="return confirm('Yakin hapus produk ini?');"
                   href="delete.php?id=<?= $p['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>

</body>
</html>
