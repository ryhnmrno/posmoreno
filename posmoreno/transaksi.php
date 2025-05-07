<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

if (!isset($_SESSION['keranjang'])) $_SESSION['keranjang'] = [];
if (!isset($_SESSION['total'])) $_SESSION['total'] = 0;
if (!isset($_SESSION['kembalian'])) $_SESSION['kembalian'] = 0;
if (!isset($_SESSION['tanggal_penjualan'])) $_SESSION['tanggal_penjualan'] = date('Y-m-d');
if (!isset($_SESSION['diskon'])) $_SESSION['diskon'] = 0;

$stok_habis_pesan = "";
$username = $_SESSION['nama_kasir'];
$nama_kasir = 'Tidak diketahui';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kode_plu'])) {
    $kode_plu = mysqli_real_escape_string($conn, $_POST['kode_plu']);
    $query = "SELECT * FROM produk WHERE id_produk = '$kode_plu'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $produk = mysqli_fetch_assoc($result);
        if ($produk['stok'] > 0) {
            $_SESSION['keranjang'][] = $produk;
            $_SESSION['total'] += $produk['harga'];
        } else {
            $stok_habis_pesan = "Yey, stok barang habis, silahkan isi kembali!";
        }
    } else {
        echo "<script>alert('Kode PLU tidak ditemukan!');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['diskon'])) {
    $diskon = floatval($_POST['diskon']);
    if ($diskon >= 0 && $diskon <= 100) {
        $_SESSION['diskon'] = $diskon;
    } else {
        echo "<script>alert('Diskon harus antara 0% - 100%!');</script>";
    }
}

$_SESSION['total_setelah_diskon'] = $_SESSION['total'];
if ($_SESSION['diskon'] > 0) {
    $_SESSION['total_setelah_diskon'] = $_SESSION['total'] - ($_SESSION['total'] * ($_SESSION['diskon'] / 100));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['uang_diberikan'])) {
    $uang_diberikan = floatval($_POST['uang_diberikan']);
    $tanggal_penjualan = $_SESSION['tanggal_penjualan'];
    $total_harga = $_SESSION['total_setelah_diskon'];

    if ($uang_diberikan >= $total_harga) {
        $_SESSION['kembalian'] = $uang_diberikan - $total_harga;

        $insert_penjualan = "INSERT INTO penjualan (tanggal_penjualan, total_harga, uang_diberikan, kembalian, nama_kasir) 
                             VALUES ('$tanggal_penjualan', '$total_harga', '$uang_diberikan', '{$_SESSION['kembalian']}', '{$_SESSION['nama_kasir']}')";
        if (mysqli_query($conn, $insert_penjualan)) {
            $id_penjualan = mysqli_insert_id($conn);

            $insert_laporan_harian = "INSERT INTO laporan_harian (id_laporan_harian, total_penjualan, tanggal_penjualan, uang_diberikan, kembalian, nama_kasir) 
                                      VALUES ('$id_penjualan', '$total_harga', '$tanggal_penjualan', '$uang_diberikan', '{$_SESSION['kembalian']}', '{$_SESSION['nama_kasir']}')";
            mysqli_query($conn, $insert_laporan_harian);

            foreach ($_SESSION['keranjang'] as $item) {
                $new_stok = $item['stok'] - 1;
                $update_stok_query = "UPDATE produk SET stok = '$new_stok' WHERE id_produk = '{$item['id_produk']}'";
                mysqli_query($conn, $update_stok_query);
            }

            echo "<script>alert('Transaksi berhasil dan tersimpan ke laporan harian!');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan transaksi: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Uang yang diberikan kurang!');</script>";
        $_SESSION['kembalian'] = 0;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $_SESSION['keranjang'] = [];
    $_SESSION['total'] = 0;
    $_SESSION['kembalian'] = 0;
    $_SESSION['diskon'] = 0;
    $_SESSION['total_setelah_diskon'] = 0;
    echo "<script>alert('Keranjang berhasil dikosongkan!');</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tanggal_penjualan'])) {
    $_SESSION['tanggal_penjualan'] = $_POST['tanggal_penjualan'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi</title>
    <link rel="stylesheet" href="css/dashboard.css?v=2">
    <script>
        function printStruk() {
            var printContent = document.getElementById("struk").innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>
</head>
<body>
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

<div class="content">
    <h2>Menu Transaksi</h2>

    <?php if ($stok_habis_pesan): ?>
        <p style="color: red; font-weight: bold;"><?php echo $stok_habis_pesan; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="kode_plu">Masukkan Kode PLU:</label>
        <input type="text" name="kode_plu" required>
        <button type="submit">Tambah</button>
    </form>

    <form method="POST">
        <label for="diskon">Masukkan Diskon (%):</label>
        <input type="number" name="diskon" min="0" max="100" required>
        <button type="submit">Terapkan Diskon</button>
    </form>

    <form method="POST">
        <label for="tanggal_penjualan">Pilih Tanggal Transaksi:</label>
        <input type="date" name="tanggal_penjualan" value="<?php echo $_SESSION['tanggal_penjualan']; ?>" required>
        <button type="submit">Simpan Tanggal</button>
    </form>

    <h3>Keranjang Belanja</h3>
    <table border="1">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
        </tr>
        <?php
        if (!empty($_SESSION['keranjang'])) {
            foreach ($_SESSION['keranjang'] as $item) {
                $harga = $item['harga'];
                if ($_SESSION['diskon'] > 0) {
                    $harga -= $harga * ($_SESSION['diskon'] / 100);
                }
                echo "<tr><td>{$item['nama_produk']}</td><td>Rp. " . number_format($harga, 0, ',', '.') . "</td></tr>";
            }
        }
        ?>
    </table>

    <form method="POST">
        <label for="uang_diberikan">Uang Diberikan:</label>
        <input type="number" name="uang_diberikan" required>
        <button type="submit">Hitung Kembalian</button>
    </form>

    <h4>Kembalian: Rp. <?php echo number_format($_SESSION['kembalian'], 0, ',', '.'); ?></h4>

    <!-- Struk -->
    <div id="struk" style="display:none;">
        <pre style="font-family: 'Courier New', monospace; font-size: 16px;">
===================================
         STRUK PEMBELIAN
===================================
Tanggal  : <?php echo date('d/m/Y'); ?>  
Alamat   : Marakas
Kasir    : <?php echo str_pad($_SESSION['nama_kasir'], 20, ' ', STR_PAD_RIGHT); ?>

-----------------------------------
Nama Produk         Harga
<?php
if (!empty($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $harga = $item['harga'];
        if ($_SESSION['diskon'] > 0) {
            $harga -= $harga * ($_SESSION['diskon'] / 100);
        }
        printf(" %-15s Rp. %7s\n", $item['nama_produk'], number_format($harga, 0, ',', '.'));
    }
}
?>
-----------------------------------
Total          : Rp. <?php echo number_format($_SESSION['total_setelah_diskon'], 0, ',', '.'); ?>  
Uang Diberikan : Rp. <?php echo number_format($_POST['uang_diberikan'] ?? 0, 0, ',', '.'); ?>  
Kembalian      : Rp. <?php echo number_format($_SESSION['kembalian'], 0, ',', '.'); ?>  
===================================
  Terima kasih telah berbelanja!!
        </pre>
    </div>

    <form method="POST" style="display: flex; gap: 10px;">
        <button type="submit" name="reset">Reset Keranjang</button>
        <button type="button" onclick="printStruk()" style="background-color: red; color: white; padding: 10px 20px; font-weight: bold; border-radius: 5px; cursor: pointer;">Cetak Struk</button>
    </form>
</div>

<div class="watermark">
  © 2025 POS App by <span class="creator-name">ryhnmrno</span>
</div>

</body>
</html>
