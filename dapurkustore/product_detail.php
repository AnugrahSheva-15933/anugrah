<?php
include "config/db.php";

if (!isset($_GET['id'])) {
    die("Produk tidak ditemukan.");
}

$id = intval($_GET['id']);
$q = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$p = mysqli_fetch_assoc($q);

if (!$p) {
    die("Produk tidak tersedia.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $p['name']; ?> - Sikil Resik</title>

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
            max-width:1100px;
            margin:40px auto;
            background:#fff;
            padding:25px;
            border-radius:10px;
            box-shadow:0 4px 12px rgba(0,0,0,0.1);
        }

        .product-wrapper {
            display:flex;
            gap:40px;
            flex-wrap:wrap;
        }

        .product-image {
            flex:1;
            min-width:300px;
        }

        .product-image img {
            width:100%;
            height:360px;
            object-fit:cover;
            border-radius:10px;
        }

        .product-info {
            flex:1;
            min-width:300px;
        }

        .product-info h2 {
            margin-top:0;
            font-size:28px;
            color:#2d3436;
        }

        .price {
            font-size:24px;
            font-weight:bold;
            color:#0984e3;
            margin:15px 0;
        }

        .stock {
            font-size:16px;
            margin-bottom:20px;
            color:#636e72;
        }

        .description {
            margin-top:20px;
            line-height:1.6;
            color:#2d3436;
        }

        .btn-add {
            display:inline-block;
            background:#00b894;
            padding:12px 20px;
            color:#fff;
            text-decoration:none;
            border-radius:8px;
            font-size:16px;
            margin-top:20px;
            transition:0.2s;
        }

        .btn-add:hover {
            background:#019170;
        }
    </style>
</head>

<body>

<header>Detail Produk</header>

<div class="container">

    <div class="product-wrapper">

        <!-- Gambar Produk -->
        <div class="product-image">
            <?php if (!empty($p['image'])): ?>
                <img src="uploads/<?= $p['image']; ?>" alt="<?= $p['name']; ?>">
            <?php else: ?>
                <img src="https://via.placeholder.com/500x350?text=No+Image" alt="Produk">
            <?php endif; ?>
        </div>

        <!-- Info Produk -->
        <div class="product-info">

            <h2><?= $p['name']; ?></h2>

            <div class="price">
                Rp <?= number_format($p['price'], 0, ',', '.'); ?>
            </div>

            <div class="stock">
                Stok Tersedia: <strong><?= $p['stock']; ?></strong>
            </div>

            <p class="description"><?= nl2br($p['description']); ?></p>

            <a class="btn-add" href="cart.php?add=<?= $p['id']; ?>">Tambah ke Keranjang</a>

        </div>

    </div>

</div>

</body>
</html>
