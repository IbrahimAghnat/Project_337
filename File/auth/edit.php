<?php
include '../config/db.php';
include '../layout/header.php';

$id = $_GET['id'];
$user_data = $conn->query("SELECT * FROM tb_users WHERE id=$id");
$data = $user_data->fetch_assoc();

if (isset($_POST['update'])) {
    $nama = $_POST['username'];
    $nama = $_POST['nama_barang'];

    $sql = "UPDATE tb_barang SET 
                kode_barang='$kode',
                nama_barang='$nama',
                kategori='$kategori',
                satuan='$satuan',
                stok='$stok'
            WHERE id=$id";
    if($conn->query($sql)){
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['kembali'])) {
    header("Location: index.php");
}
?>

<form method="post">
    <h2>Edit Barang</h2>
    <label>Kode:</label><br>
    <input type="text" name="kode_barang" value="<?= $data['kode_barang']; ?>"><br>
    <label>Nama:</label><br>
    <input type="text" name="nama_barang" value="<?= $data['nama_barang']; ?>"><br>
    <label>Kategori:</label><br>
    <input type="text" name="kategori" value="<?= $data['kategori']; ?>"><br>
    <label>Satuan:</label><br>
    <input type="text" name="satuan" value="<?= $data['satuan']; ?>"><br>
    <label>Stok:</label><br>
    <input type="number" name="stok" value="<?= $data['stok']; ?>"><br><br>
    <button type="submit" name="update">Update</button>
</form>
<form method="post">
    <br><button type="submit" name="kembali">Kembali</button>
</form>

<?php include '../layout/footer.php'; ?>