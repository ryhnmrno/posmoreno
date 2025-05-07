<?php
session_start();

// Ambil nama kasir dari session
$nama_kasir = isset($_SESSION['nama_kasir']) ? $_SESSION['nama_kasir'] : 'Tidak Diketahui';

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksiA
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah user memilih tanggal
$tanggal_pilih = isset($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');

// Mengambil total penjualan harian berdasarkan tanggal yang dipilih
$query_total = "SELECT SUM(total_harga) as total_penjualan FROM penjualan WHERE DATE(tanggal_penjualan) = '$tanggal_pilih'";
$result_total = $conn->query($query_total);
$row_total = $result_total->fetch_assoc();
$total_penjualan = $row_total['total_penjualan'] ?? 0;

// Ambil data transaksi berdasarkan tanggal yang dipilih
$query = "SELECT id_penjualan, tanggal_penjualan, total_harga, uang_diberikan, kembalian, nama_kasir FROM penjualan WHERE DATE(tanggal_penjualan) = '$tanggal_pilih'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian</title>
    <link rel="stylesheet" href="css/dashboard.css?v=2">
    <style>
       @media print {
    .sidebar {
        display: none !important;
    }
    .content {
        margin-left: 0 !important;
        width: 100% !important;
    }
    #printButton, .printRow, #formTanggal, .aksiHeader, .aksiCell { 
        display: none !important;
    }
}

    </style>
    <script>
        function printRow(rowId) {
            let row = document.getElementById(rowId).cloneNode(true);
            row.querySelector(".aksiCell")?.remove();
            
            let printContent = `<table border="1">
                                    <tr>
                                        <th>ID Laporan Harian</th>
                                        <th>Waktu Transaksi</th>
                                        <th>Nama Kasir</th>
                                        <th>Total Harga</th>
                                        <th>Uang Diberikan</th>
                                        <th>Kembalian</th>
                                    </tr>
                                    ${row.outerHTML}
                                </table>`;
            
            let newWindow = window.open("", "", "width=600,height=400");
            newWindow.document.write("<html><head><title>Cetak Transaksi</title></head><body>");
            newWindow.document.write("<h2>Detail Transaksi</h2>");
            newWindow.document.write(printContent);
            newWindow.document.write("</body></html>");
            newWindow.document.close();
            newWindow.print();
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
    <form method="POST" id="formTanggal">
        <label for="tanggal">Pilih Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" value="<?php echo $tanggal_pilih; ?>">
        <button type="submit">Tampilkan</button>
    </form>

    <table border="1">
        <tr>
            <th>ID Laporan Harian</th>
            <th>Waktu Transaksi</th>
            <th>Nama Kasir</th>
            <th>Total Harga</th>
            <th>Uang Diberikan</th>
            <th>Kembalian</th>
            <th class="aksiHeader">Aksi</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $row_id = "row_" . $row['id_penjualan'];
                echo "<tr id='{$row_id}'>
                        <td>{$row['id_penjualan']}</td>
                        <td>{$row['tanggal_penjualan']}</td>
                        <td>{$row['nama_kasir']}</td>
                        <td>Rp. " . number_format($row['total_harga'], 0, ',', '.') . "</td>
                        <td>Rp. " . number_format($row['uang_diberikan'], 0, ',', '.') . "</td>
                        <td>Rp. " . number_format($row['kembalian'], 0, ',', '.') . "</td>
                        <td class='aksiCell'><button class='printRow' onclick='printRow(\"{$row_id}\")'>Cetak</button></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data transaksi pada tanggal ini</td></tr>";
        }
        ?>
    </table>

    <button id="printButton" onclick="window.print()">Cetak Seluruh Laporan</button>

    <?php
    $conn->close();
    ?>
</div>

<div class="watermark">
  © 2025 POS App by <span class="creator-name">ryhnmrno</span>
</div>

</body>
</html>
