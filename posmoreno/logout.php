<?php
session_start();
session_destroy(); // Menghapus semua sesi

// Redirect ke halaman login
header("Location: login.php");
exit();
?>
