<?php
include "../../config/db.php";

// VALIDASI ID
if (!isset($_GET['id'])) {
    die("ID pesanan tidak valid.");
}

$id = (int) $_GET['id'];

// AMBIL DATA ORDER
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Pesanan tidak ditemukan.");
}

// AMBIL ITEM PESANAN + NAMA PRODUK
$stmt = $conn->prepare("
    SELECT 
        oi.quantity,
        oi.price,
        p.name AS product_name
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$items = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan - Dapurku Store</title>

    <style>
        body { font-family: Arial; background:#f6f6f6; padding:20px; }
        .box {
            max-width:900px; margin:auto; background:#fff; padding:20px;
            border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1);
        }
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        th, td { padding:10px; border-bottom:1px solid #ddd; }
        .btn-back {
            display:inline-block; margin-bottom:15px;
            background:#6c757d; padding:8px 12px; color:#fff;
            border-radius:6px; text-decoration:none;
        }
        .btn-update {
            background:#00b894; padding:8px 14px; color:#fff;
            border-radius:6px; border:none; cursor:pointer;
        }
        select {
            padding:8px; border-radius:6px; border:1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="box">

    <a class="btn-back" href="orders.php">← Kembali</a>

    <h2>Detail Pesanan #<?= $order['id']; ?></h2>

    <p><b>ID Customer:</b> <?= $order['customer_id']; ?></p>
    <p><b>ID Alamat:</b> <?= $order['address_id']; ?></p>
    <p><b>Total Belanja:</b> Rp <?= number_format($order['total_price'],0,',','.'); ?></p>
    <p><b>Status:</b> <?= ucfirst($order['status']); ?></p>

    <h3>Produk Dipesan</h3>

    <table>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>

        <?php while ($i = $items->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($i['product_name']); ?></td>
            <td>Rp <?= number_format($i['price'],0,',','.'); ?></td>
            <td><?= $i['quantity']; ?></td>
            <td>Rp <?= number_format($i['price'] * $i['quantity'],0,',','.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <h3>Ubah Status Pesanan</h3>

    <form method="POST" action="update_status.php">
        <input type="hidden" name="id" value="<?= $order['id']; ?>">

        <select name="status" required>
            <option value="pending" <?= $order['status']=='pending'?'selected':''; ?>>Pending</option>
            <option value="paid" <?= $order['status']=='paid'?'selected':''; ?>>Paid</option>
            <option value="shipped" <?= $order['status']=='shipped'?'selected':''; ?>>Dikirim</option>
            <option value="cancel" <?= $order['status']=='cancel'?'selected':''; ?>>Dibatalkan</option>
        </select>

        <button class="btn-update" type="submit">Update Status</button>
    </form>

</div>

</body>
</html>
