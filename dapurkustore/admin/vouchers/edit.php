<?php
include "../../config/db.php";

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM vouchers WHERE id=$id"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Voucher</title>
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
            background: #28a745; color: #fff; padding: 10px 15px;
            border-radius: 6px; text-decoration: none;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Edit Voucher</h2>

    <form method="POST">
        <input type="text" name="code" value="<?= $data['code']; ?>" required>
        <input type="number" name="discount" value="<?= $data['discount_percent']; ?>" required>

        <button class="btn" type="submit">Update</button>
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

    mysqli_query($conn, "UPDATE vouchers SET code='$code', discount_percent='$discount' WHERE id=$id");
    header("Location: index.php");
}
?>
