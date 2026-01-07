<?php
include "../../config/db.php";

// VALIDASI ID
if (!isset($_GET['id'])) {
    die("ID produk tidak valid.");
}

$id = (int) $_GET['id'];

// AMBIL DATA PRODUK
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();

if (!$p) {
    die("Produk tidak ditemukan.");
}

// PROSES UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = trim($_POST['name']);
    $price = (int) $_POST['price'];
    $stock = (int) $_POST['stock'];

    if ($name == "" || $price < 0 || $stock < 0) {
        $err = "Data tidak valid.";
    } else {

        // JIKA UPLOAD GAMBAR BARU
        if (!empty($_FILES['image']['name'])) {

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowed = ['jpg','jpeg','png'];

            if (!in_array(strtolower($ext), $allowed)) {
                $err = "Format gambar harus JPG atau PNG.";
            } else {

                // HAPUS GAMBAR LAMA
                if (!empty($p['image']) && file_exists("../../uploads/".$p['image'])) {
                    unlink("../../uploads/".$p['image']);
                }

                $newName = uniqid().".".$ext;
                move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/".$newName);
                $p['image'] = $newName;
            }
        }

        if (!isset($err)) {
            $stmt = $conn->prepare("
                UPDATE products 
                SET name=?, price=?, stock=?, image=? 
                WHERE id=?
            ");
            $stmt->bind_param("sdisi", $name, $price, $stock, $p['image'], $id);
            $stmt->execute();

            header("Location: products.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - Dapurku Store</title>

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
            background:#0984e3; color:#fff; padding:10px 15px;
            border:none; border-radius:6px; cursor:pointer;
            width:100%;
            font-size:16px;
        }
        img {
            width:120px; height:120px; object-fit:cover;
            border-radius:8px; margin-bottom:10px;
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
    <h2>✏️ Edit Produk</h2>

    <?php if(isset($err)): ?>
        <div class="error"><?= $err; ?></div>
    <?php endif; ?>

    <?php if (!empty($p['image'])): ?>
        <img src="../../uploads/<?= htmlspecialchars($p['image']); ?>">
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Produk</label>
        <input type="text" name="name" value="<?= htmlspecialchars($p['name']); ?>" required>

        <label>Harga</label>
        <input type="number" name="price" value="<?= $p['price']; ?>" required>

        <label>Stok</label>
        <input type="number" name="stock" value="<?= $p['stock']; ?>" required>

        <label>Ganti Gambar (opsional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Update Produk</button>
    </form>
</div>

</body>
</html>
