<?php
session_start();
include 'koneksi.php'; // Koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kasir = $_POST['nama_kasir'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $level = $_POST['level'];
   

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah email sudah digunakan
    $query_check = "SELECT * FROM akun WHERE email = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Email sudah terdaftar! Gunakan email lain.'); window.location='daftar.php';</script>";
        exit();
    }

    // Simpan data ke database
    $query = "INSERT INTO akun (nama_kasir, level, email, password, no_hp, tgl_lahir, alamat) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $nama_kasir, $level, $email, $hashed_password, $no_hp, $tgl_lahir, $alamat);

    if ($stmt->execute()) {
        echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Pendaftaran gagal! Coba lagi.'); window.location='daftar.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - POS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h3>Daftar Akun Baru</h3>
    <form action="daftar.php" method="POST">
        <div class="form-group">
            <label>Nama Kasir:</label>
            <input type="text" name="nama_kasir" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Level:</label>
            <select name="level" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>


        <button type="submit" class="btn-primary">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>

</body>
</html>
