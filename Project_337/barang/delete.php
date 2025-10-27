<?php
include '../config/db.php';

$id = $_GET['id'];

$sql = "DELETE FROM tb_barang WHERE id=$id";
if ($conn->query($sql)) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}

include '../layout/header.php';
?>