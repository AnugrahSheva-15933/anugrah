<?php
include "../../config/db.php";

// VALIDASI ID
if (!isset($_GET['id'])) {
    die("ID produk tidak valid.");
}

$id = (int) $_GET['id'];

// CEK PRODUK ADA ATAU TIDAK
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Produk tidak ditemukan.");
}

// HAPUS FILE GAMBAR JIKA ADA
if (!empty($product['image'])) {
    $path = "../../uploads/" . $product['image'];
    if (file_exists($path)) {
        unlink($path);
    }
}

// HAPUS DATA PRODUK
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: products.php");
exit;
