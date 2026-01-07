<?php
session_start();
include "config/db.php";

// Jika keranjang kosong → redirect
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    die("Keranjang kosong. <a href='product_list.php'>Belanja dulu</a>");
}

// Hitung total
$grandTotal = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));
    $grandTotal += $p['price'] * $qty;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Sikil Resik</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f5f6fa;
            margin:0;
            padding:0;
        }

        header {
            background:#2d3436;
            color:#fff;
            padding:20px;
            text-align:center;
            font-size:24px;
            font-weight:bold;
        }

        .container {
            max-width:900px;
            margin:40px auto;
            background:#fff;
            padding:25px;
            border-radius:10px;
            box-shadow:0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top:0;
        }

        .form-group {
            margin-bottom:20px;
        }

        label {
            font-weight:bold;
        }

        input, select, textarea {
            width:100%;
            padding:12px;
            margin-top:6px;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:16px;
        }

        .summary-box {
            margin-top:20px;
            padding:15px;
            background:#f1f2f6;
            border-radius:10px;
        }

        .btn-pay {
            display:block;
            width:100%;
            padding:14px;
            background:#00b894;
            color:#fff;
            border:none;
            border-radius:10px;
            cursor:pointer;
            font-size:18px;
            margin-top:20px;
        }

        .btn-pay:hover {
            background:#019170;
        }

    </style>
</head>
<body>

<header>Checkout</header>

<div class="container">

    <h2>Informasi Pengiriman</h2>

    <form action="process_checkout.php" method="POST">

        <div class="form-group">
            <label>Nama Penerima</label>
            <input type="text" name="name" required placeholder="Nama lengkap">
        </div>

        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" name="phone" required placeholder="0812xxxxxxx">
        </div>

        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea name="address" rows="4" required placeholder="Alamat lengkap pengiriman"></textarea>
        </div>

        <div class="form-group">
            <label>Jasa Pengiriman</label>
            <select name="shipping" required>
                <option value="JNE">JNE</option>
                <option value="J&T">J&T</option>
                <option value="SiCepat">SiCepat</option>
            </select>
        </div>

        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select name="payment" required>
                <option value="transfer">Transfer Bank</option>
                <option value="cod">COD (Bayar di tempat)</option>
                <option value="ewallet">E-Wallet (Dana, OVO, ShopeePay)</option>
                <option value="va">Virtual Account</option>
            </select>
        </div>

        <div class="summary-box">
            <h3>Total Belanja</h3>
            <p style="font-size:22px; font-weight:bold; color:#0984e3;">
                Rp <?= number_format($grandTotal, 0, ',', '.'); ?>
            </p>
        </div>

        <button class="btn-pay">Bayar Sekarang</button>

    </form>

</div>

</body>
</html>
