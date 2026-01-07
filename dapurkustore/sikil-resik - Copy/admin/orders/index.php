<?php
include "../../config/db.php";
$data = mysqli_query($conn, "SELECT * FROM orders");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Pesanan</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f6f6f6; padding: 20px; }
        h2 { text-align: center; margin-bottom: 25px; }
        .container {
            max-width: 900px; margin: auto; background: #fff;
            padding: 20px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f0f0f0; }
        .btn-detail {
            background: #007bff; padding: 7px 12px; color: #fff;
            border-radius: 6px; text-decoration: none;
        }
        .status {
            padding: 5px 10px; border-radius: 4px; color: #fff; font-size: 14px;
        }
        .pending { background: #ffc107; }
        .paid { background: #28a745; }
        .cancel { background: #dc3545; }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar Pesanan</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>ID_Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Details</th>
        </tr>

        <?php while ($o = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td>#<?= $o['id']; ?></td>
            <td><?= $o['customer_id']; ?></td>
            <td>Rp <?= number_format($o['total_amount'], 0, ',', '.'); ?></td>
            <td>
                <span class="status 
                    <?= $o['status'] == 'Pending' ? 'pending' : ($o['status']=='Paid'?'paid':'cancel'); ?>">
                    <?= $o['status']; ?>
                </span>
            </td>
            <td>
                <a class="btn-detail" href="detail.php?id=<?= $o['id']; ?>">Detail</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
