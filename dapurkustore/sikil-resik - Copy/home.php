<?php include "config/db.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home - DapurKu Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            text-align: center;
            padding-top: 50px;
        }
        .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #fff;
            background: #ff7a00;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .menu a:hover {
            background: #e66a00;
        }
    </style>
</head>
<body>

    <h1>🍳 Selamat Datang di DapurKu Store</h1>
    <p>Pusat penjualan alat-alat dapur lengkap & berkualitas</p>

    <div class="menu">
        <a href="product_list.php">Lihat Produk</a>
        <a href="cart.php">Keranjang</a>
        <a href="login.php">Login</a>
    </div>

</body>
</html>
