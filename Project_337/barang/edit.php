<?php
include '../config/db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM tb_barang WHERE id=$id");
$data = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $kode = $conn->real_escape_string($_POST['kode_barang']);
    $nama = $conn->real_escape_string($_POST['nama_barang']);
    $kategori = $conn->real_escape_string($_POST['kategori']);
    $satuan = $conn->real_escape_string($_POST['satuan']);
    
    $check = $conn->query("SELECT * FROM tb_barang WHERE kode_barang='$kode' AND id != $kode");
    if ($check->num_rows > 0) {
        $error = "⚠️ Kode barang sudah digunakan, silakan gunakan kode lain.";
    } else {
      $sql = "UPDATE tb_barang SET 
                  kode_barang='$kode',
                  nama_barang='$nama',
                  kategori='$kategori',
                  satuan='$satuan'
              WHERE id=$id";
      if ($conn->query($sql)) {
          header("Location: index.php");
          exit;
      } else {
          $error = "Error: " . $conn->error;
      }
    }
}

if (isset($_POST['kembali'])) {
    header("Location: index.php");
    exit;
}

include '../layout/header.php';
?>

<div style="padding:24px;"> 
  <div style="
      max-width:600px;
      margin:0 auto;
      background:#fff;
      padding:32px;
      border-radius:12px;
      box-shadow:0 2px 8px rgba(0,0,0,0.08);
  ">
    <h2 style="
        text-align:center;
        font-size:26px;
        font-weight:600;
        color:#2563eb;
        margin-bottom:24px;
    ">✏️ Edit Barang</h2>

    <?php if (isset($error)) { ?>
      <p style="color:#dc2626; text-align:center; margin-bottom:16px;"><?= $error; ?></p>
    <?php } ?>

    <?php if ($_SESSION["role"] == "admin") { ?>
      <form method="post" style="display:flex; flex-direction:column; gap:16px;">
        <div>
          <label style="display:block; font-weight:500; margin-bottom:6px;">Kode Barang</label>
          <input type="text" name="kode_barang" value="<?= $data['kode_barang']; ?>" required style="
              width:100%; padding:10px 14px;
              border:1px solid #d1d5db; border-radius:8px;
              font-size:14px; outline:none; box-sizing:border-box;
              transition:border 0.2s;
          " onfocus="this.style.borderColor='#2563eb';" 
             onblur="this.style.borderColor='#d1d5db';">
        </div>

        <div>
          <label style="display:block; font-weight:500; margin-bottom:6px;">Nama Barang</label>
          <input type="text" name="nama_barang" value="<?= $data['nama_barang']; ?>" required style="
              width:100%; padding:10px 14px;
              border:1px solid #d1d5db; border-radius:8px;
              font-size:14px; outline:none; box-sizing:border-box;
              transition:border 0.2s;
          " onfocus="this.style.borderColor='#2563eb';" 
             onblur="this.style.borderColor='#d1d5db';">
        </div>

        <div>
          <label style="display:block; font-weight:500; margin-bottom:6px;">Kategori</label>
          <input type="text" name="kategori" value="<?= $data['kategori']; ?>" required style="
              width:100%; padding:10px 14px;
              border:1px solid #d1d5db; border-radius:8px;
              font-size:14px; outline:none; box-sizing:border-box;
              transition:border 0.2s;
          " onfocus="this.style.borderColor='#2563eb';" 
             onblur="this.style.borderColor='#d1d5db';">
        </div>

        <div>
          <label style="display:block; font-weight:500; margin-bottom:6px;">Satuan</label>
          <input type="text" name="satuan" value="<?= $data['satuan']; ?>" required style="
              width:100%; padding:10px 14px;
              border:1px solid #d1d5db; border-radius:8px;
              font-size:14px; outline:none; box-sizing:border-box;
              transition:border 0.2s;
          " onfocus="this.style.borderColor='#2563eb';" 
             onblur="this.style.borderColor='#d1d5db';">
        </div>

        <div style="display:flex; gap:12px; justify-content:flex-end;">
          <button type="submit" name="update" style="
              flex:1; background:#2563eb; color:#fff;
              padding:12px; border:none; border-radius:8px;
              font-size:15px; font-weight:500;
              cursor:pointer; transition:background 0.3s;
          " onmouseover="this.style.background='#1e40af';" 
             onmouseout="this.style.background='#2563eb';">
            💾 Update
          </button>

          <button type="submit" name="kembali" formnovalidate style="
              flex:1; background:#6b7280; color:#fff;
              padding:12px; border:none; border-radius:8px;
              font-size:15px; font-weight:500;
              cursor:pointer; transition:background 0.3s;
          " onmouseover="this.style.background='#4b5563';" 
             onmouseout="this.style.background='#6b7280';">
            ⬅️ Kembali
          </button>
        </div>
      </form>
    <?php } else { ?>
      <p style="text-align:center; font-size:16px; font-weight:500; margin-bottom:16px; color:#dc2626;">
        ANDA BUKAN ADMIN
      </p>
      <div style="text-align:center;">
        <a href="index.php" style="
            display:inline-block;
            background:#6b7280; color:#fff;
            padding:10px 16px; border-radius:8px;
            text-decoration:none; font-size:14px;
            transition:background 0.3s;
        " onmouseover="this.style.background='#4b5563';" 
           onmouseout="this.style.background='#6b7280';">
          ⬅️ Kembali
        </a>
      </div>
    <?php } ?>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
