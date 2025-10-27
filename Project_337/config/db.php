<?php
$host = "localhost";
$user = "root";
$pass = "";
// $db   = "db_gudangPabrik";
$db   = "db_gudang_pabrik";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$base_url = "http://localhost/project_337/";
// http://localhost/project_337/auth/login.php
// http://localhost/proyekkamu/