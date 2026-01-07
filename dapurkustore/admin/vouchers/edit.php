<?php
session_start();
include "../../config/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: vouchers.php");
    exit;
}

$id = (int) $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code     = mysqli_real_escape_string($conn, $_POST['code']);
    $discount = (int) $_POST['discount'];

    mysqli_query($conn, "
        UPDATE vouchers 
        SET code='$code', discount_percent='$discount'
        WHERE id=$id
    ");

    header("Location: vouchers.php");
    exit;
}

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM vouchers WHERE id=$id")
);

if (!$data) {
    header("Location: vouchers.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Voucher</title>

    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        .box {
            max-width: 500px; margin: auto; background: #fff;
            padding: 25px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align:center; margin-bottom:20px; }
        input {
            width: 100%; padding: 10px; margin-bottom: 15px;
            border-radius: 6px; border: 1px solid #ccc;
        }
        .btn {
            background: #28a745; color: #fff;
            padding: 10px 15px; border-radius: 6px;
            border: none; cursor: pointer;
            width: 100%;
        }
        a { text-decoration:none; display:inline-block; margin-top:15px; }
    </style>
</head>
<body>

<div class="box">
    <h2>✏️ Edit Voucher</h2>

    <form method="POST">
        <label>Kode Voucher</label>
        <input type="text" name="code" value="<?= $data['code']; ?>" required>

        <label>Diskon (%)</label>
        <input type="number" name="discount" value="<?= $data['discount_percent']; ?>" required>

        <button class="btn" type="submit">Update Voucher</button>
    </form>

    <a href="vouchers.php">← Kembali</a>
</div>

</body>
</html>
