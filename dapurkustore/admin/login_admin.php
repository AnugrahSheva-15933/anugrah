<?php
session_start();
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $pass  = trim($_POST['password']);

    if ($username === "" || $pass === "") {
        $err = "Username dan password wajib diisi!";
    } else {

        $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            if (password_verify($pass, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];

                header("Location: dashboard_admin.php");
                exit;
            } else {
                $err = "Password salah!";
            }
        } else {
            $err = "Akun admin tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Dapurku Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            width: 320px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #ff7a00;
            border: none;
            color: white;
            font-weight: bold;
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
        .note {
            font-size: 12px;
            color: #777;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>🔐 Login Admin</h2>
    <p>Dapurku Store</p>

    <?php if (isset($err)) echo "<div class='error'>$err</div>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username Admin" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Masuk</button>
    </form>

    <div class="note">
        Halaman khusus administrator
    </div>
</div>

</body>
</html>
