<?php
session_start();
include '../koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil order terakhir user
$orderQuery = mysqli_query($conn, "
    SELECT * FROM orders 
    WHERE user_id = '$user_id' 
    ORDER BY created_at DESC 
    LIMIT 1
");

$order = mysqli_fetch_assoc($orderQuery);

if (!$order) {
    echo "Data pesanan tidak ditemukan.";
    exit;
}

$order_id = $order['id'];

// Ambil item pesanan
$itemsQuery = mysqli_query($conn, "
    SELECT * FROM order_items 
    WHERE order_id = '$order_id'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Berhasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
        }
        h2 {
            color: #28a745;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        table th {
            background: #f0f0f0;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>✅ Checkout Berhasil</h2>
    <p>Terima kasih telah berbelanja di <strong>Dapurku Store</strong>.</p>

    <p>
        <strong>Kode Pesanan:</strong> <?= $order['order_code']; ?><br>
        <strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($order['created_at'])); ?><br>
        <strong>Status:</strong> <?= ucfirst($order['status']); ?><br>
        <strong>Metode Pembayaran:</strong> <?= $order['payment_method']; ?>
    </p>

    <h3>Detail Pesanan</h3>

    <table>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>

        <?php while ($item = mysqli_fetch_assoc($itemsQuery)) : ?>
        <tr>
            <td><?= $item['product_name']; ?></td>
            <td>Rp <?= number_format($item['price'], 0, ',', '.'); ?></td>
            <td><?= $item['quantity']; ?></td>
            <td>Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
        </tr>
        <?php endwhile; ?>

        <tr>
            <td colspan="3" class="total">Total</td>
            <td class="total">
                Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?>
            </td>
        </tr>
    </table>

    <p><strong>Alamat Pengiriman:</strong><br>
        <?= nl2br($order['shipping_address']); ?>
    </p>

    <a href="../index.php" class="btn">Kembali ke Beranda</a>
</div>

</body>
</html>
