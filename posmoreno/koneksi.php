<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pos_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
