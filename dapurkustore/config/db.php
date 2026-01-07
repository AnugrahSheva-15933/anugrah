<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "sikil_resik"; // sesuaikan dengan nama database kamu di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
