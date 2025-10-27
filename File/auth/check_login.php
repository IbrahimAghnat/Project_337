<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
?>

<?php
session_start();
include __DIR__ . '/../config/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}