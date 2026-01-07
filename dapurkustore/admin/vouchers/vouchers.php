<?php
session_start();
include "../../config/db.php";

$data = mysqli_query($conn, "
    SELECT * FROM vouchers
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Voucher - Dapurku Store</title>

    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        .container {
            max-width: 900px; margin: auto; background: #fff;
            padding: 25px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; margin-bottom: 20px; }
        .btn {
            background: #007bff; padding: 10px 15px; color: #fff;
            border-radius: 6px; text-decoration: none;
            display: inline-block; margin-bottom: 15px;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; }
        th { background: #28a745; color: #fff; }
        tr:hover { background: #f0f0f0; }
        .edit { color: #28a745; text-decoration: none; }
        .delete { color: #dc3545; text-decoration: none; }
        .active { color: green; font-weight: bold; }
        .inactive { color: red; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">

    <h2>🎟️ Manajemen Voucher</h2>

    <a class="btn" href="add.php">+ Tambah Voucher</a>

    <table>
        <tr>
            <th>Kode Voucher</th>
            <th>Diskon</th>
            <th>Min. Belanja</th>
            <th>Status</th>
            <th>Kadaluarsa</th>
            <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($data) > 0): ?>
            <?php while ($v = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $v['code']; ?></td>
                <td><?= $v['discount_percent']; ?>%</td>
                <td>Rp <?= number_format($v['min_purchase'],0,',','.'); ?></td>
                <td>
                    <?= $v['is_active'] 
                        ? '<span class="active">Aktif</span>' 
                        : '<span class="inactive">Nonaktif</span>'; ?>
                </td>
                <td><?= $v['expired_at']; ?></td>
                <td>
                    <a class="edit" href="edit.php?id=<?= $v['id']; ?>">Edit</a> |
                    <a class="delete" href="delete.php?id=<?= $v['id']; ?>"
                       onclick="return confirm('Yakin hapus voucher ini?');">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center;">
                    Belum ada voucher
                </td>
            </tr>
        <?php endif; ?>
    </table>

</div>

</body>
</html>
