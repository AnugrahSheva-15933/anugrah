<?php include "../../config/db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Voucher</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        .box {
            max-width: 500px; margin: auto; background: #fff;
            padding: 20px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        input {
            width: 100%; padding: 10px; margin-bottom: 15px;
            border-radius: 6px; border: 1px solid #ccc;
        }
        .btn {
            background: #007bff; color: #fff; padding: 10px 15px;
            border-radius: 6px; text-decoration: none; display: inline-block;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Tambah Voucher</h2>

    <form method="POST">
        <input type="text" name="code" placeholder="Kode Voucher" required>
        <input type="number" name="discount" placeholder="Diskon %" required>

        <button class="btn" type="submit">Simpan</button>
    </form>

    <br>
    <a href="index.php">← Kembali</a>
</div>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $discount = $_POST['discount'];

    mysqli_query($conn, "INSERT INTO vouchers (code, discount_percent) VALUES ('$code', '$discount')");
    header("Location: index.php");
}
?>
