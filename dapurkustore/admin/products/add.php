<?php
include "../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = trim($_POST['name']);
    $price = (int) $_POST['price'];
    $stock = (int) $_POST['stock'];

    // VALIDASI
    if ($name === "" || $price < 0 || $stock < 0) {
        $err = "Data produk tidak valid.";
    }

    // VALIDASI & UPLOAD GAMBAR
    if (!isset($err)) {

        $imageName = null;

        if (!empty($_FILES['image']['name'])) {

            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png'];

            if (!in_array($ext, $allowed)) {
                $err = "Format gambar harus JPG atau PNG.";
            } else {
                $imageName = uniqid() . "." . $ext;
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    "../../uploads/" . $imageName
                );
            }
        }
    }

    // SIMPAN KE DATABASE
    if (!isset($err)) {

        $stmt = $conn->prepare("
            INSERT INTO products (name, price, stock, image, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("sdis", $name, $price, $stock, $imageName);
        $stmt->execute();

        header("Location: products.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - Dapurku Store</title>

    <style>
        body { font-family: Arial; background:#f6f6f6; padding:20px; }
        .box {
            max-width:520px; margin:auto; background:#fff;
            padding:20px; border-radius:12px;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
        }
        input {
            width:100%; padding:10px; margin:8px 0;
            border-radius:6px; border:1px solid #ccc;
        }
        button {
            background:#00b894; color:#fff;
            padding:12px; border:none;
            border-radius:8px; cursor:pointer;
            width:100%; font-size:16px;
        }
        .error {
            background:#ffe0e0; color:#b00020;
            padding:10px; border-radius:6px;
            margin-bottom:10px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>➕ Tambah Produk Baru</h2>

    <?php if (isset($err)): ?>
        <div class="error"><?= $err; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Produk</label>
        <input type="text" name="name" required>

        <label>Harga</label>
        <input type="number" name="price" required>

        <label>Stok</label>
        <input type="number" name="stock" required>

        <label>Gambar Produk</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Simpan Produk</button>
    </form>
</div>

</body>
</html>
