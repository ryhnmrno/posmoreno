<!--  email: admin@gmail.com
      password : admin123 -->

<?php
session_start();
include 'koneksi.php'; // Koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email ada di database
    $query = "SELECT * FROM akun WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama_kasir'] = $user['nama_kasir'];
            $_SESSION['level'] = $user['level'];

            header("Location: dashboard.php"); // Redirect ke halaman utama
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h3>INDOMART</h3>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn-primary">Login</button>
    </form>
    <p>Belum punya akun? <a href="daftar.php">Daftar di sini</a></p>
</div>

</body>
</html>
