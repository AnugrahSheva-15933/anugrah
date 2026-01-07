<?php
include "config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama     = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $pass     = trim($_POST['password']);

    if ($nama === "" || $username === "" || $pass === "") {
        $err = "Semua field wajib diisi!";
    } else {

        // cek username sudah dipakai atau belum
        $cek = $conn->prepare("SELECT id FROM customers WHERE username = ?");
        $cek->bind_param("s", $username);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $err = "Username sudah digunakan!";
        } else {

            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO customers (nama, username, password) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $nama, $username, $hash);
            $stmt->execute();

            header("Location: login.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Dapurku Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-box {
            background: white;
            padding: 30px;
            width: 320px;
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
            border: none;
            color: white;
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
    </style>
</head>
<body>

<div class="register-box">
    <h2>📝 Daftar Akun</h2>
    <p>Dapurku Store</p>

    <?php if (isset($err)) echo "<div class='error'>$err</div>"; ?>

    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
    </form>
</div>

</body>
</html>
