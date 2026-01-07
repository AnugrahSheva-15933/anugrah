<?php
include "config/db.php";

if (!isset($_GET['id'])) {
    die("Produk tidak ditemukan.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$p = $result->fetch_assoc();

if (!$p) {
    die("Produk tidak tersedia.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($p['name']); ?> - Dapurku Store</title>

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
            color:#ff7a00;
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

<header>🍳 Detail Produk Dapurku Store</header>

<div class="container">

    <div class="product-wrapper">

        <div class="product-image">
            <?php if (!empty($p['image'])): ?>
                <img src="uploads/<?= htmlspecialchars($p['image']); ?>" alt="<?= htmlspecialchars($p['name']); ?>">
            <?php else: ?>
                <img src="https://via.placeholder.com/500x350?text=No+Image" alt="Produk">
            <?php endif; ?>
        </div>

        <div class="product-info">

            <h2><?= htmlspecialchars($p['name']); ?></h2>

            <div class="price">
                Rp <?= number_format($p['price'], 0, ',', '.'); ?>
            </div>

            <div class="stock">
                Stok tersedia: <strong><?= (int)$p['stock']; ?></strong>
            </div>

            <p class="description">
                <?= nl2br(htmlspecialchars($p['description'])); ?>
            </p>

            <?php if ($p['stock'] > 0): ?>
                <a class="btn-add" href="cart.php?add=<?= $p['id']; ?>">Tambah ke Keranjang</a>
            <?php else: ?>
                <p style="color:red;font-weight:bold;">Stok habis</p>
            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>
