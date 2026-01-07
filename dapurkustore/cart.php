<?php
session_start();
include "config/db.php";

// pastikan cart selalu array
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ------------------------------
// TAMBAH KE KERANJANG
// ------------------------------
if (isset($_GET['add'])) {
    $id = intval($_GET['add']);

    $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $p = $res->fetch_assoc();

    if ($p) {
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 1;
        } else {
            if ($_SESSION['cart'][$id] < $p['stock']) {
                $_SESSION['cart'][$id]++;
            }
        }
    }

    header("Location: cart.php");
    exit;
}

// ------------------------------
// TAMBAH JUMLAH
// ------------------------------
if (isset($_GET['plus'])) {
    $id = intval($_GET['plus']);

    $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $p = $res->fetch_assoc();

    if ($p && $_SESSION['cart'][$id] < $p['stock']) {
        $_SESSION['cart'][$id]++;
    }

    header("Location: cart.php");
    exit;
}

// ------------------------------
// KURANGI JUMLAH
// ------------------------------
if (isset($_GET['minus'])) {
    $id = intval($_GET['minus']);

    if (isset($_SESSION['cart'][$id])) {
        if ($_SESSION['cart'][$id] > 1) {
            $_SESSION['cart'][$id]--;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }

    header("Location: cart.php");
    exit;
}

// ------------------------------
// HAPUS PRODUK
// ------------------------------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - Dapurku Store</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f5f6fa;
            margin:0;
            padding:0;
        }
        header {
            background:#ff7a00;
            color:#fff;
            padding:20px;
            text-align:center;
            font-size:24px;
            font-weight:bold;
        }
        .container {
            max-width:1100px;
            margin:40px auto;
            background:#fff;
            padding:25px;
            border-radius:10px;
            box-shadow:0 4px 12px rgba(0,0,0,0.1);
        }
        table {
            width:100%;
            border-collapse: collapse;
            margin-top:20px;
        }
        th, td {
            padding:12px;
            border-bottom:1px solid #eee;
        }
        th {
            background:#f1f2f6;
        }
        .qty-btn {
            padding:6px 10px;
            background:#dfe6e9;
            border-radius:5px;
            text-decoration:none;
            font-weight:bold;
            color:#000;
        }
        .delete-btn {
            background:#d63031;
            color:#fff;
            padding:8px 12px;
            border-radius:6px;
            text-decoration:none;
        }
        .checkout-btn {
            display:block;
            width:220px;
            text-align:center;
            margin-top:30px;
            padding:12px;
            background:#00b894;
            color:#fff;
            border-radius:8px;
            text-decoration:none;
            font-size:18px;
        }
        .empty {
            text-align:center;
            font-size:22px;
            margin:40px 0;
            color:#636e72;
        }
    </style>
</head>

<body>

<header>🛒 Keranjang Belanja Dapurku Store</header>

<div class="container">

<h2>Daftar Isi Keranjang</h2>

<?php if (count($_SESSION['cart']) == 0): ?>
    <p class="empty">Keranjang belanja kosong.</p>
<?php else: ?>

<table>
<tr>
    <th>Produk</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>

<?php
$grandTotal = 0;

foreach ($_SESSION['cart'] as $id => $qty):
    $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $p = $res->fetch_assoc();

    if (!$p) continue;

    $total = $p['price'] * $qty;
    $grandTotal += $total;
?>
<tr>
    <td><?= htmlspecialchars($p['name']); ?></td>
    <td>Rp <?= number_format($p['price'],0,',','.'); ?></td>
    <td>
        <a class="qty-btn" href="cart.php?minus=<?= $id; ?>">−</a>
        <?= $qty; ?>
        <a class="qty-btn" href="cart.php?plus=<?= $id; ?>">+</a>
    </td>
    <td>Rp <?= number_format($total,0,',','.'); ?></td>
    <td>
        <a class="delete-btn" href="cart.php?delete=<?= $id; ?>"
           onclick="return confirm('Hapus produk ini?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h2 style="text-align:right; margin-top:20px;">
    Total Belanja:
    <span style="color:#ff7a00;">Rp <?= number_format($grandTotal,0,',','.'); ?></span>
</h2>

<a class="checkout-btn" href="checkout.php">Checkout</a>

<?php endif; ?>

</div>

</body>
</html>
