<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi ke database tersedia

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

// Tambah Produk
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = intval($_POST['harga']);
    $stok = intval($_POST['stok']);

    $query = "INSERT INTO produk (nama_produk, harga, stok) VALUES ('$nama', '$harga', '$stok')";
    mysqli_query($conn, $query);
    header("Location: produk.php");
}

// Edit Produk
if (isset($_POST['edit'])) {
    $id = intval($_POST['id_produk']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = intval($_POST['harga']);
    $stok = intval($_POST['stok']);

    $query = "UPDATE produk SET nama_produk='$nama', harga='$harga', stok='$stok' WHERE id_produk='$id'";
    mysqli_query($conn, $query);
    header("Location: produk.php");
}

// Hapus Produk
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM produk WHERE id_produk='$id'");
    header("Location: produk.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - POS</title>
    <link rel="stylesheet" href="css/dashboard.css?v=2">
    <script>
        // Fungsi untuk toggle tampilkan form tambah produk
        function toggleForm() {
            const form = document.getElementById('tambahProdukForm');
            form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
        }
    </script>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2><a href="dashboard.php" style="text-decoration: none; color: white;">POS Dashboard</a></h2>
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
    

    <!-- Tombol +Tambah Produk -->
    <button onclick="toggleForm()" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">+ Tambah Produk</button>

    <!-- Form Tambah Produk -->
    <div id="tambahProdukForm" style="display: none; margin-top: 20px;">
        <form method="POST">
            <label>Nama Produk:</label>
            <input type="text" name="nama_produk" required>
            
            <label>Harga:</label>
            <input type="number" name="harga" required>
            
            <label>Stok:</label>
            <input type="number" name="stok" required>
            
            <button type="submit" name="tambah">Tambah Produk</button>
        </form>
    </div>

    

    <!-- Tabel Daftar Produk -->
    <div class="table-container">
       <br><h3>Daftar Produk</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM produk");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id_produk']}</td>
                        <td>{$row['nama_produk']}</td>
                        <td>Rp. " . number_format($row['harga'], 0, ',', '.') . "</td>
                        <td>{$row['stok']}</td>
                        <td>
                           <!-- Tombol Edit -->
                        <a href='produk.php?edit={$row['id_produk']}'><button class='editButton'>Edit</button></a> |
                        <!-- Tombol Hapus -->
                        <a href='produk.php?hapus={$row['id_produk']}' onclick='return confirm(\"Yakin ingin menghapus?\")'><button class='deleteButton'>Delete</button></a>
                    </td>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>

    <!-- Form Edit Produk -->
    <?php
    if (isset($_GET['edit'])) {
        $id = intval($_GET['edit']);
        $result = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id'");
        $row = mysqli_fetch_assoc($result);
    ?>
        <div class="form-container">
            <h3>Edit Produk</h3>
            <form method="POST">
                <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">
                
                <label>Nama Produk:</label>
                <input type="text" name="nama_produk" value="<?php echo $row['nama_produk']; ?>" required>
                
                <label>Harga:</label>
                <input type="number" name="harga" value="<?php echo $row['harga']; ?>" required>
                
                <label>Stok:</label>
                <input type="number" name="stok" value="<?php echo $row['stok']; ?>" required>
                
                <button type="submit" name="edit">Simpan Perubahan</button>
            </form>
        </div>
    <?php } ?>
</div>
<div class="watermark">
  © 2025 POS App by <span class="creator-name">ryhnmrno</span>
  </div>
</body>
</html>
