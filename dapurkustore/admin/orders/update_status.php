<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['id']) || !isset($_POST['status'])) {
        die("Error: Data tidak lengkap.");
    }

    $id = intval($_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $query = "UPDATE orders SET status='$status' WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        header("Location: detail.php?id=" . $id);
        exit;
    } else {
        echo "SQL ERROR: " . mysqli_error($conn);
    }
}
?>
