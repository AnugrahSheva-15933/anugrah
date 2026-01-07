<?php
session_start();
include "../../config/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];
$delete = mysqli_query($conn, "DELETE FROM vouchers WHERE id=$id");
header("Location: index.php");
exit;
