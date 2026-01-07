<?php
session_start();
include "config/db.php";

if ($_POST) {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $q = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email' AND password='$pass'");
    
    if (mysqli_num_rows($q) > 0) {
        $_SESSION['customer'] = $email;
        header("Location: dashboard_customer.php");
        exit;
    } else {
        $err = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Customer - DapurKu Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 30px;
            width: 300px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #ff7a00;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #e66a00;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #ff7a00;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>🍳 Login Customer</h2>
    <p>DapurKu Store</p>

    <?php if(isset($err)) echo "<div class='error'>$err</div>"; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <a href="register.php">Belum punya akun? Daftar</a>
</div>

</body>
</html>
