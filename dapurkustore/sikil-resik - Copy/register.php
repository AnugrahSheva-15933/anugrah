<?php
include "config/db.php";

if ($_POST) {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    mysqli_query($conn, "INSERT INTO customers(name,email,password) VALUES('$name','$email','$pass')");
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register Customer</title>
</head>
<body>

<h2>Daftar Akun Baru</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Nama lengkap"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <button>Daftar</button>
</form>

</body>
</html>
