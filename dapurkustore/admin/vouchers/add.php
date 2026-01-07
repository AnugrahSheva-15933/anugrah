<?php
include "../../config/db.php";

/* ===============================
   PROSES SIMPAN VOUCHER
================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $code     = trim($_POST['code']);
    $discount = (int) $_POST['discount'];

    if ($code !== "" && $discount > 0) {
        mysqli_query(
            $conn,
            "INSERT INTO vouchers (code, discount_percent)
             VALUES ('$code', '$discount')"
        );
        header("Location: vouchers.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Voucher</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        .box {
            max-width: 500px; margin: auto; background: #fff;
            padding: 20px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; }
        input {
            width: 100%; padding: 10px; margin-bottom: 15px;
            border-radius: 6px; border: 1px solid #ccc;
        }
        button {
            background: #007bff; color: #fff;
            padding: 10px 15px; border: none;
            border-radius: 6px; cursor: pointer;
            width: 100%;
        }
        a { display: inline-block; margin-top: 15px; text-decoration: none; }
    </style>
</head>
<body>

<div class="box">
    <h2>Tambah Voucher</h2>

    <form method="POST">
        <input type="text" name="code" placeholder="Kode Voucher" required>
        <input type="number" name="discount" placeholder="Diskon (%)" min="1" max="100" required>

        <button type="submit">Simpan</button>
    </form>

    <a href="index.php">← Kembali</a>
</div>

</body>
</html>
