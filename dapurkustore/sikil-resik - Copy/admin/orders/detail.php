<?php
include "../../config/db.php";

$id = $_GET['id'];
$order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE id=$id"));
$items = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id=$id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
    <style>
        body { font-family: Arial; background: #f6f6f6; padding: 20px; }
        .box {
            max-width: 900px; margin: auto; background: #fff; padding: 20px;
            border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; }
        .btn-back {
            display: inline-block; margin-bottom: 15px;
            background: #6c757d; padding: 8px 12px; color: #fff;
            border-radius: 6px; text-decoration: none;
        }
        .btn-update {
            background: #007bff; padding: 8px 12px; color: #fff;
            border-radius: 6px; text-decoration: none;
        }
        select {
            padding: 8px; border-radius: 6px; border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="box">
    <a class="btn-back" href="index.php">← Kembali</a>

    <h2>Detail Pesanan #<?= $order['id']; ?></h2>

    <p><b>id_Customer:</b> <?= $order['customer_id']; ?></p>
    <p><b>id_Alamat:</b> <?= $order['address_id']; ?></p>
    <p><b>Total:</b> Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></p>

    <h3>Produk dipesan:</h3>

    <table>
        <tr>
            <th>Produk</th><th>Harga</th><th>Jumlah</th>
        </tr>

        <?php while ($i = mysqli_fetch_assoc($items)): ?>
        <tr>
            <td><?= $i['product_variant_id']; ?></td>
            <td><?= $i['price']; ?></td>
            <td><?= number_format($i['quantity'], 0, ',', '.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <h3>Ubah Status Pesanan</h3>

    <form method="POST" action="update_status.php">
        <input type="hidden" name="id" value="<?= $order['id']; ?>">

        <select name="status" required>
            <option value="Pending" <?= $order['status']=='Pending'?'selected':''; ?>>Pending</option>
            <option value="Paid" <?= $order['status']=='Paid'?'selected':''; ?>>Paid</option>
            <option value="Cancel" <?= $order['status']=='Cancel'?'selected':''; ?>>Cancel</option>
        </select>

        <button class="btn-update" type="submit">Update</button>
    </form>

</div>

</body>
</html>
