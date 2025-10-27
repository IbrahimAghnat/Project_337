<?php
include '../config/db.php';
include '../layout/header.php';

$barang = $conn->query("SELECT * FROM tb_barang");

if (isset($_POST['simpan'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];

    // Batasi dan amankan input
    $ket = mysqli_real_escape_string($conn, substr(trim($_POST['keterangan']), 0, 150));
    
    $id_user = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "NULL";

    $stok_total = $conn->query("SELECT stok FROM tb_barang WHERE id=$id_barang")->fetch_assoc();
    if ($stok_total['stok'] < $jumlah) {
        echo "<p style='color:red; text-align:center; font-weight:bold;'>Stok tidak mencukupi!</p>";
    } else {
        $sisa = $jumlah;
        $batches = $conn->query("SELECT * FROM tb_stok_detail 
                                 WHERE id_barang=$id_barang AND jumlah > 0 
                                 ORDER BY tanggal_expired ASC");
        while($sisa > 0 && $batch = $batches->fetch_assoc()){
            $ambil = min($sisa, $batch['jumlah']);
            $conn->query("UPDATE tb_stok_detail SET jumlah = jumlah - $ambil WHERE id={$batch['id']}");
            $sisa -= $ambil;
        }
        $conn->query("UPDATE tb_barang SET stok = stok - $jumlah WHERE id=$id_barang");
        $conn->query("INSERT INTO tb_transaksi (id_barang, id_user, jenis, jumlah, keterangan) 
                      VALUES ('$id_barang', $id_user, 'keluar', '$jumlah', '$ket')");
        echo "<p style='color:green; text-align:center; font-weight:bold;'>Transaksi berhasil!</p>";
    }
}
?>

<div style="
  padding:10px; 
  display:flex; 
  justify-content:center; 
  align-items:center; 
  min-height:80vh;
">
  <div style="
    background:#ffffff; 
    padding:40px; 
    border-radius:15px; 
    box-shadow:0 6px 18px rgba(0,0,0,0.1); 
    width:100%; 
    max-width:520px;
    border-top:6px solid #dc2626;
  ">
    <h2 style="color:#dc2626; text-align:center; margin-bottom:28px; font-size:24px; font-weight:700;">
      Barang Keluar
    </h2>

    <form method="post" style="display:flex; flex-direction:column; gap:20px;">

      <style>
        .form-box {
          width: 100%;
          padding: 12px 14px;
          border-radius: 5px;
          border: 1px solid #cbd5e1;
          background: #f8fafc;
          font-size: 15px;
          transition: all 0.25s ease;
          outline: none;
          box-sizing: border-box;
          appearance: none;
        }

        .form-box:focus {
          border-color: #dc2626;
          background: #fff;
          box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }

        textarea.form-box {
          resize: none;
          min-height: 90px;
        }

        select.form-box {
          background-image: url("data:image/svg+xml;utf8,<svg fill='%23dc2626' height='16' viewBox='0 0 24 24' width='16' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
          background-repeat: no-repeat;
          background-position: right 14px center;
          background-size: 16px;
          padding-right: 40px;
        }

        /* Tambahkan info batas karakter */
        .char-count {
          font-size: 13px;
          color: #64748b;
          text-align: right;
        }
      </style>

      <!-- Pilih Barang -->
      <div style="display:flex; flex-direction:column; gap:6px;">
        <label style="font-weight:600; color:#dc2626;">Pilih Barang</label>
        <select name="id_barang" class="form-box" required>
          <option value="">-- Pilih Barang --</option>
          <?php while($row = $barang->fetch_assoc()): ?>
            <option value="<?= $row['id']; ?>"><?= $row['nama_barang']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <!-- Jumlah -->
      <div style="display:flex; flex-direction:column; gap:6px;">
        <label style="font-weight:600; color:#dc2626;">Jumlah</label>
        <input type="number" name="jumlah" class="form-box" placeholder="Masukkan jumlah barang" required>
      </div>

      <!-- Keterangan -->
      <div style="display:flex; flex-direction:column; gap:6px;">
        <label style="font-weight:600; color:#dc2626;">Keterangan</label>
        <textarea name="keterangan" class="form-box" maxlength="150" placeholder="keterangan (opsional)"></textarea>
        <div class="char-count">Maksimal 150 karakter</div>
      </div>

      <!-- Tombol -->
      <button type="submit" name="simpan" style="
        margin-top:12px; padding:14px; width:60%; align-self:center;
        background:linear-gradient(to right, #dc2626, #ad3434ff); 
        color:#fff; border:none; border-radius:12px; 
        font-weight:600; font-size:16px; letter-spacing:0.5px;
        cursor:pointer; transition:all 0.3s; box-shadow:0 4px 12px rgba(0,0,0,0.15);
      " onmouseover="this.style.opacity='0.9'; this.style.transform='scale(1.03)'; this.style.boxShadow='0 6px 16px rgba(0,0,0,0.25)'"
         onmouseout="this.style.opacity='1'; this.style.transform='scale(1)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'">
        Simpan
      </button>
    </form>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
