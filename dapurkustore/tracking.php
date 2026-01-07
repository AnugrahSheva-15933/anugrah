<?php
include "config/db.php";

$order = null;
$order_items = [];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data order
    $order = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT * FROM orders WHERE id = $id")
    );

    if ($order) {
        // Ambil item pesanan
        $order_items = mysqli_query(
            $conn,
            "SELECT oi.*, p.name 
             FROM order_items oi 
             JOIN products p ON oi.product_id = p.id 
             WHERE oi.order_id = $id"
        );
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tracking Pesanan</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            max-width: 600px;
        }
        input, button {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
        }
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .item {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>

<h2>Tracking Pesanan</h2>

<form method="GET">
    <input type="text" name="id" placeholder="Masukkan Nomor Pesanan" required>
    <button type="submit">Lacak</button>
</form>

<?php if (isset($_GET['id'])): ?>

    <?php if (!$order): ?>
        <p style="color:red;">Pesanan tidak ditemukan.</p>
    <?php else: ?>

        <div class="card">
            <h3>Informasi Pesanan</h3>
            <p><strong>No Pesanan:</strong> <?= $order['id']; ?></p>
            <p><strong>Nama:</strong> <?= $order['customer_name']; ?></p>
            <p><strong>Alamat:</strong> <?= $order['address']; ?></p>
            <p><strong>Kurir:</strong> <?= $order['shipping_method']; ?></p>
            <p><strong>Status:</strong> <?= $order['status'] ?? "Menunggu Diproses"; ?></p>
            <p><strong>Total Harga:</strong> Rp <?= number_format($order['total_price']); ?></p>
        </div>

        <div class="card">
            <h3>Isi Pesanan</h3>

            <?php while ($item = mysqli_fetch_assoc($order_items)): ?>
                <div class="item">
                    <?= $item['name']; ?>  
                    (<?= $item['quantity']; ?> x Rp <?= number_format($item['price']); ?>)
                </div>
            <?php endwhile; ?>

        </div>

    <?php endif; ?>

<?php endif; ?>

</body>
</html>
