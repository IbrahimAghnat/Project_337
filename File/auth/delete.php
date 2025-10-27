<?php
include '../config/db.php';

$id = $_GET['id'];

$sql = "DELETE FROM tb_users WHERE id=$id";
if ($conn->query($sql)) {
    header("Location: home.php");
} else {
    echo "Error: " . $conn->error;
}
?>