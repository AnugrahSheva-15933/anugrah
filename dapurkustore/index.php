<?php
// session_start();
// include "config/db.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DapurKu Store - Toko Alat Dapur</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
            background: #f4f4f4;
        }
        header {
            background: #ff7a00;
            padding: 15px;
            color: white;
        }
        header h1 {
            margin: 0;
        }
        nav a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .hero {
            background: #ffa94d;
            padding: 80px 30px;
            text-align: center;
            color: white;
        }
        .hero h2 {
            font-size: 40px;
            margin: 0;
        }
        .content {
            padding: 30px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #ff7a00;
            color: white;
            text-decoration: none;
            margin-top: 15px;
            border-radius: 6px;
        }
        .btn:hover {
            background: #e66a00;
        }
        footer {
            background: #222;
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h1>🍳 DapurKu Store</h1>
    <nav>
        <a href="home.php">Home</a>
        <a href="product_list.php">Produk</a>
        <a href="cart.php">Keranjang</a>
        <a href="login.php">Login</a>
        <a href="register.php">Daftar</a>
    </nav>
</header>

<div class="hero">
    <h2>Lengkapi Dapur Anda Sekarang</h2>
    <p>Menjual alat-alat dapur berkualitas: panci, wajan, pisau, blender, dan lainnya.</p>
    <a class="btn" href="product_list.php">Belanja Sekarang</a>
</div>

<div class="content">
    <h2>Kenapa Belanja di DapurKu Store?</h2>
    <ul>
        <li>🍽️ Alat Dapur Berkualitas & Awet</li>
        <li>🚚 Pengiriman Cepat & Aman</li>
        <li>💳 Pembayaran Mudah</li>
        <li>⭐ Ribuan Pelanggan Puas</li>
    </ul>

    <a class="btn" href="product_list.php">Lihat Semua Produk</a>
</div>

<footer>
    © <?php echo date("Y"); ?> DapurKu Store — Toko Alat Dapur Online
</footer>

</body>
</html>
