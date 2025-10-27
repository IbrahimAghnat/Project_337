<?php
include '../config/db.php';

if (isset($_POST['simpan'])) {
    $kode = $conn->real_escape_string($_POST['kode_barang']);
    $nama = $conn->real_escape_string($_POST['nama_barang']);
    $kategori = $conn->real_escape_string($_POST['kategori']);
    $satuan = $conn->real_escape_string($_POST['satuan']);

    $sql = "INSERT INTO tb_barang (kode_barang, nama_barang, kategori, satuan, stok) 
            VALUES ('$kode','$nama','$kategori','$satuan',0)";
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Error: " . $conn->error;
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
        color:#4338ca;
        margin-bottom:24px;
    ">➕ Tambah Barang</h2>

    <?php if (isset($error)) { ?>
      <p style="color:#dc2626; text-align:center; margin-bottom:16px;"><?= $error; ?></p>
    <?php } ?>

    <?php if ($_SESSION["role"] == "admin") { ?>
      <!-- Form Simpan + Kembali berdampingan -->
      <form method="post" style="display:flex; flex-direction:column; gap:16px;">
        <div>
          <label style="display:block; font-weight:500; margin-bottom:6px;">Kode Barang</label>
          <input type="text" name="kode_barang" required style="
              width:100%;
              padding:10px 14px;
              border:1px solid #d1d5db;
              border-radius:8px;
              font-size:14px;
              outline:none;
              box-sizing:border-box;
              transition:border 0.2s;
          " onfocus="this.style.borderColor='#4338ca';" 
             onblur="this.style.borderColor='#d1d5db';" required>
        </div>

        <div>
          <label style="display:block; font-weight:500; margin-bottom:6px;">Nama Barang</label>
          <input type="text" name="nama_barang" required style="
              width:100%;
              padding:10px 14px;
              border:1px solid #d1d5db;
              border-radius:8px;
              font-size:14px;
              outline:none;
              box-sizing:border-box;
              transition:border 0.2s;
          " onfocus="this.style.borderColor='#4338ca';" 
             onblur="this.style.borderColor='#d1d5db';" required>
        </div>

        <div>
          <label style="display:block; font-weight:500; margin-bottom:6px;">Kategori</label>
          <input type="text" name="kategori" style="
              width:100%;
              padding:10px 14px;
              border:1px solid #d1d5db;
              border-radius:8px;
              font-size:14px;
              outline:none;
              box-sizing:border-box;
              transition:border 0.2s;
          " onfocus="this.style.borderColor='#4338ca';" 
             onblur="this.style.borderColor='#d1d5db';" required>
        </div>

        <div>
          <label style="display:block; font-weight:500; margin-bottom:6px;">Satuan</label>
          <input type="text" name="satuan" style="
              width:100%;
              padding:10px 14px;
              border:1px solid #d1d5db;
              border-radius:8px;
              font-size:14px;
              outline:none;
              box-sizing:border-box;
              transition:border 0.2s;
          " onfocus="this.style.borderColor='#4338ca';" 
             onblur="this.style.borderColor='#d1d5db';" required>
        </div>

        <div style="display:flex; gap:12px; justify-content:flex-end;">
          <button type="submit" name="simpan" style="
              flex:1;
              background:#4338ca; color:#fff;
              padding:12px; border:none; border-radius:8px;
              font-size:15px; font-weight:500;
              cursor:pointer; transition:background 0.3s;
          " onmouseover="this.style.background='#3730a3';" 
             onmouseout="this.style.background='#4338ca';">
            💾 Simpan
          </button>

          <button type="submit" name="kembali" formnovalidate style="
              flex:1;
              background:#6b7280; color:#fff;
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
