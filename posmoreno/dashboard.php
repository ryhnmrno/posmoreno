<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - POS</title>
    <link rel="stylesheet" href="css/dashboard.css?v=2">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>POS Dashboard</h2>
    <ul>
        <li><a href="transaksi.php"> Transaksi</a></li>
        <li><a href="laporan_harian.php"> Laporan Harian</a></li>
        <li><a href="laporan_bulanan.php"> Laporan Bulanan</a></li>
        <li><a href="produk.php"> Produk</a></li>
        <li><a href="profile.php"> Profil</a></li>
        <li><a href="logout.php" class="logout"> Logout</a></li>
    </ul>
</div>

<!-- Konten Utama -->
<div class="content">
    <h2>Selamat datang, <?php echo $_SESSION['nama_kasir']; ?>!</h2>
    <p>Level: <strong><?php echo $_SESSION['level']; ?></strong></p>
    <p>Silakan pilih menu di sebelah kiri untuk memulai.</p>
</div>
</div>

<div class="watermark">
  © 2025 POS App by <span class="creator-name">ryhnmrno</span>
</div>

</body>
</html>
