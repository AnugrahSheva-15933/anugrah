<?php
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === "" || $password === "") {
        $err = "Username dan password wajib diisi!";
    } else {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO admins (username, password) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $username, $hash);

        if ($stmt->execute()) {
            $success = "Admin berhasil dibuat!";
        } else {
            $err = "Username sudah digunakan!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
</head>
<body>

<h2>Register Admin</h2>

<?php if (isset($err)) echo "<p style='color:red'>$err</p>"; ?>
<?php if (isset($success)) echo "<p style='color:green'>$success</p>"; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Daftar</button>
</form>

</body>
</html>
