<?php
include "../../config/db.php";

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$p = mysqli_fetch_assoc($data);

if (isset($_POST['submit'])) {
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    mysqli_query($conn, "UPDATE products 
                         SET name='$name', price='$price', stock='$stock' 
                         WHERE id=$id");

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <style>
        body { font-family: Arial; background: #f6f6f6; padding: 20px; }
        .box {
            max-width: 500px; margin: auto; background: #fff;
            padding: 20px; border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        input {
            width: 100%; padding: 10px; margin: 8px 0;
            border-radius: 6px; border: 1px solid #ccc;
        }
        button {
            background: #28a745; color: #fff; padding: 10px 15px;
            border: none; border-radius: 6px; cursor: pointer;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Edit Produk</h2>

    <form method="POST">
        <label>Nama Produk</label>
        <input type="text" name="name" value="<?= $p['name']; ?>" required>

        <label>Harga</label>
        <input type="number" name="price" value="<?= $p['price']; ?>" required>

        <label>Stok</label>
        <input type="number" name="stock" value="<?= $p['stock']; ?>" required>

        <button type="submit" name="submit">Update</button>
    </form>
</div>

</body>
</html>
