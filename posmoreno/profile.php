<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    die("Session id_user tidak ditemukan, pastikan login dulu.");
}
$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "SELECT * FROM akun WHERE id_user = '$id_user'");
$user = mysqli_fetch_assoc($query);

$nama_kasir = $user['nama_kasir'] ?? '';
$email = $user['email'] ?? '';
$no_hp = $user['no_hp'] ?? '';
$alamat = $user['alamat'] ?? '';
$foto_profil = $user['foto'] ?? 'css/img/4x6.png';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $nama_kasir = $_POST['nama_kasir'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($conn, "UPDATE akun SET nama_kasir='$nama_kasir', email='$email', no_hp='$no_hp', alamat='$alamat' WHERE id_user='$id_user'");
    if ($update) {
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil: " . mysqli_error($conn) . "');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $password_baru = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $update_pass = mysqli_query($conn, "UPDATE akun SET password='$password_baru' WHERE id_user='$id_user'");
    if ($update_pass) {
        echo "<script>alert('Password berhasil diperbarui!'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah password!');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_foto'])) {
    if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $folder = "uploads/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $file_ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png'];

        if (in_array(strtolower($file_ext), $allowed_ext)) {
            $filename = $folder . time() . "_" . basename($_FILES['foto']['name']);
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $filename)) {
                mysqli_query($conn, "UPDATE akun SET foto='$filename' WHERE id_user='$id_user'");
                echo "<script>alert('Foto profil berhasil diperbarui!'); window.location='profile.php';</script>";
            } else {
                echo "<script>alert('Gagal mengunggah foto.');</script>";
            }
        } else {
            echo "<script>alert('Format file tidak valid. Hanya JPG, JPEG, dan PNG yang diperbolehkan.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="css/dashboard.css?v=2">
    <style>
        .container { display: flex; gap: 20px; padding: 20px; }
        .content { flex: 1; display: grid; grid-template-columns: 1fr 2fr 1fr; gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        img.profile-pic { width: 120px; height: 120px; border-radius: 10px; border: 2px solid #ccc; display: block; margin: 0 auto; }
        button { background: #3498db; color: white; padding: 10px; border: none; cursor: pointer; border-radius: 5px; }
        .photo-container { display: flex; flex-direction: column; align-items: center; gap: 10px; }
    </style>
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
    
    <div class="container">
        <div class="content">
            <div class="card">
                <h3 style="text-align: center;">Foto Pengguna</h3>
                <div class="photo-container">
                    <img src="<?= htmlspecialchars($foto_profil); ?>?t=<?= time(); ?>" class="profile-pic" alt="Foto Profil">
                    <form method="post" enctype="multipart/form-data">
                        <input type="file" name="foto" accept="image/*" required>
                        <button type="submit" name="upload_foto">Unggah Foto</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <h3>Kelola Pengguna</h3>
                <form method="post">
                    <label>Nama:</label>
                    <input type="text" name="nama_kasir" value="<?= htmlspecialchars($nama_kasir); ?>"><br>
                    <label>Email:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($email); ?>"><br>
                    <label>Telepon:</label>
                    <input type="text" name="no_hp" value="<?= htmlspecialchars($no_hp); ?>"><br>
                    <label>Alamat:</label>
                    <textarea name="alamat"><?= htmlspecialchars($alamat); ?></textarea><br>
                    <button type="submit" name="update_profile">Simpan Perubahan</button>
                </form>
            </div>
            <div class="card">
                <h3>Ganti Password</h3>
                <form method="post">
                <label>Username:</label>
                <input type="text" value="admin" disabled><br>
                    <label>Password Baru:</label>
                    <input type="password" name="password"><br>
                    <br> <button type="submit" name="update_password">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
    
<div class="watermark">
  © 2025 POS App by <span class="creator-name">ryhnmrno</span>
</div>

</body>
</html>
