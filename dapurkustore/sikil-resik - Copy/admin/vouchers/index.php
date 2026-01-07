<?php
include "../../config/db.php";
$data = mysqli_query($conn, "SELECT * FROM vouchers");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Voucher</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        .container {
            max-width: 800px; margin: auto; background: #fff;
            padding: 20px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; margin-bottom: 20px; }
        a.btn {
            background: #007bff; padding: 10px 15px; color: #fff;
            border-radius: 6px; text-decoration: none; margin-bottom: 10px;
            display: inline-block;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f0f0f0; }
        a.edit { color: #28a745; text-decoration: none; }
        a.delete { color: #dc3545; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">

    <h2>Daftar Voucher</h2>
    <a class="btn" href="add.php">Tambah Voucher</a>

    <table>
        <tr>
            <th>Kode</th>
            <th>Diskon</th>
            <th>Aksi</th>
        </tr>

        <?php while ($v = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $v['code']; ?></td>
            <td><?= $v['discount_percent']; ?>%</td>
            <td>
                <a class="edit" href="edit.php?id=<?= $v['id']; ?>">Edit</a> |
                <a class="delete" href="delete.php?id=<?= $v['id']; ?>"
                   onclick="return confirm('Yakin hapus voucher ini?');">
                   Hapus
                </a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>

</div>

</body>
</html>
