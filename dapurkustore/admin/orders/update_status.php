<?php
include "../../config/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Akses tidak diizinkan.");
}

// VALIDASI INPUT
if (!isset($_POST['id'], $_POST['status'])) {
    die("Data tidak lengkap.");
}

$id = (int) $_POST['id'];
$status = $_POST['status'];

// STATUS YANG DIIZINKAN
$allowedStatus = ['pending', 'paid', 'shipped', 'cancel'];

if (!in_array($status, $allowedStatus)) {
    die("Status tidak valid.");
}

// CEK ORDER ADA ATAU TIDAK
$check = $conn->prepare("SELECT id FROM orders WHERE id = ?");
$check->bind_param("i", $id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    die("Pesanan tidak ditemukan.");
}

// UPDATE STATUS (AMAN)
$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    header("Location: detail.php?id=" . $id);
    exit;
} else {
    die("Gagal memperbarui status.");
}
