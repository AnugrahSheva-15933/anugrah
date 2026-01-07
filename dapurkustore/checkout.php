<?php
session_start();
include "config/db.php";

// WAJIB LOGIN
if (!isset($_SESSION['customer_id'])) {
    die("Silakan login terlebih dahulu. <a href='login.php'>Login</a>");
}

// KERANJANG KOSONG
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    die("Keranjang kosong. <a href='product_list.php'>Belanja dulu</a>");
}

// HITUNG TOTAL
$grandTotal = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $stmt = $conn->prepare("SELECT price, stock FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $p = $res->fetch_assoc();

    if (!$p) continue;

    // batasi qty sesuai stok
    if ($qty > $p['stock']) {
        $qty = $p['stock'];
        $_SESSION['cart'][$id] = $qty;
    }

    $grandTotal += $p['price'] * $qty;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Dapurku Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f5f6fa;
            margin:0;
            padding:0;
        }
        header {
            background:#ff7a00;
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
        .form-group { margin-bottom:20px; }
        label { font-weight:bold; }
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
            width:100%;
            padding:14px;
            background:#00b894;
            color:#fff;
            border:none;
            border-radius:10px;
            font-size:18px;
            cursor:pointer;
            margin-top:20px;
        }
        .btn-pay:hover { background:#019170; }
    </style>
</head>
<body>

<header>🧾 Checkout Dapurku Store</header>

<div class="container">

<form action="process_checkout.php" method="POST">

    <div class="form-group">
        <label>Nama Penerima</label>
        <input type="text" name="name" required>
    </div>

    <div class="form-group">
        <label>Nomor Telepon</label>
        <input type="text" name="phone" required>
    </div>

    <div class="form-group">
        <label>Alamat Lengkap</label>
        <textarea name="address" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label>Jasa Pengiriman</label>
        <select name="shipping" required>
            <option>JNE</option>
            <option>J&T</option>
            <option>SiCepat</option>
        </select>
    </div>

    <div class="form-group">
        <label>Metode Pembayaran</label>
        <select name="payment" required>
            <option value="transfer">Transfer Bank</option>
            <option value="cod">COD</option>
            <option value="ewallet">E-Wallet</option>
            <option value="va">Virtual Account</option>
        </select>
    </div>

    <div class="summary-box">
        <h3>Total Belanja</h3>
        <p style="font-size:22px;font-weight:bold;color:#ff7a00;">
            Rp <?= number_format($grandTotal,0,',','.'); ?>
        </p>
    </div>

    <button class="btn-pay">Buat Pesanan</button>

</form>

</div>
</body>
</html>
