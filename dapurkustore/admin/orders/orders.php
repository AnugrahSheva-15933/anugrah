<?php
include "../../config/db.php";

$data = mysqli_query($conn, "
    SELECT id, customer_id, total, status, created_at
    FROM orders
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pesanan - Dapurku Store</title>

    <style>
        body { font-family: Arial, sans-serif; background:#f6f6f6; padding:20px; }
        h2 { text-align:center; margin-bottom:25px; }
        .container {
            max-width:1000px; margin:auto; background:#fff;
            padding:20px; border-radius:12px;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
        }
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        th, td { padding:12px 10px; border-bottom:1px solid #ddd; }
        tr:hover { background:#f9f9f9; }

        .btn-detail {
            background:#0984e3; padding:7px 14px; color:#fff;
            border-radius:6px; text-decoration:none;
            font-size:14px;
        }

        .status {
            padding:6px 12px;
            border-radius:20px;
            color:#fff;
            font-size:13px;
            text-transform:capitalize;
        }
        .pending { background:#f1c40f; color:#000; }
        .paid { background:#2ecc71; }
        .shipped { background:#3498db; }
        .cancel { background:#e74c3c; }
    </style>
</head>
<body>

<div class="container">

    <h2>📦 Manajemen Pesanan</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Total Belanja</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($data) == 0): ?>
            <tr>
                <td colspan="5" style="text-align:center;">Belum ada pesanan.</td>
            </tr>
        <?php endif; ?>

        <?php while ($o = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td>#<?= $o['id']; ?></td>
            <td><?= $o['customer_id']; ?></td>
            <td>Rp <?= number_format($o['total'],0,',','.'); ?></td>
            <td>
                <span class="status <?= $o['status']; ?>">
                    <?= $o['status']; ?>
                </span>
            </td>
            <td>
                <a class="btn-detail" href="detail.php?id=<?= $o['id']; ?>">
                    Detail
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</div>

</body>
</html>
