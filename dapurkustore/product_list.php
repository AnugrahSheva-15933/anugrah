<?php include "config/db.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk - Sikil Resik</title>

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
            padding:10px;
        }

        .product-grid {
            display:grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap:20px;
        }

        .card {
            background:#fff;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
            transition:0.2s;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow:0 6px 15px rgba(0,0,0,0.15);
        }

        .card img {
            width:100%;
            height:200px;
            object-fit:cover;
        }

        .card-body {
            padding:15px;
        }

        .card-body h3 {
            margin:0;
            font-size:18px;
            color:#2d3436;
        }

        .price {
            font-size:16px;
            font-weight:bold;
            color:#0984e3;
            margin:8px 0;
        }

        .btn-detail {
            display:inline-block;
            padding:10px 15px;
            background:#00b894;
            color:#fff;
            text-decoration:none;
            border-radius:5px;
            transition:0.2s;
        }
        .btn-detail:hover {
            background:#019170;
        }

        .empty {
            text-align:center;
            font-size:20px;
            margin-top:50px;
            color:#636e72;
        }
    </style>
</head>

<body>

<header>Sikil Resik - Katalog Produk</header>

<div class="container">

<h2 style="margin-bottom:20px;">Daftar Produk</h2>

<div class="product-grid">

<?php
$data = mysqli_query($conn, "SELECT * FROM products");

if (mysqli_num_rows($data) == 0):
    echo "<p class='empty'>Belum ada produk tersedia.</p>";
endif;

while ($p = mysqli_fetch_assoc($data)):
?>
    <div class="card">

        <!-- Jika ada kolom gambar -->
        <?php if (!empty($p['image'])): ?>
            <img src="uploads/<?= $p['image']; ?>" alt="Produk">
        <?php else: ?>
            <img src="https://via.placeholder.com/300x200?text=No+Image" alt="Produk">
        <?php endif; ?>

        <div class="card-body">
            <h3><?= $p['name']; ?></h3>
            <p class="price">Rp <?= number_format($p['price'], 0, ',', '.'); ?></p>
            <a class="btn-detail" href="product_detail.php?id=<?= $p['id']; ?>">Detail</a>
        </div>

    </div>
<?php endwhile; ?>

</div>

</div>

</body>
</html>
