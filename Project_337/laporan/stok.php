<?php
include '../config/db.php';
include '../layout/header.php';

$result = $conn->query("SELECT * FROM tb_barang");
?>

<div style="padding:24px;">
  <div style="
      background:#f9fafb; 
      padding:24px; 
      border-radius:12px; 
      box-shadow:0 2px 8px rgba(0,0,0,0.08);
  ">
    <h2 style="
        color:#1e3a8a; 
        font-size:28px; 
        margin-bottom:20px; 
        text-align:center;
    ">
      Laporan Stok Gudang
    </h2>

    <div style="
        background:#fff; 
        border-radius:6px; 
        box-shadow:0 1px 4px rgba(0,0,0,0.1); 
        overflow:hidden;
    ">
      <table cellpadding="12" cellspacing="0" style="
          width:100%; 
          border-collapse:separate; 
          border-spacing:0; 
          font-size:16px;
      ">
        <thead>
          <tr style="background:#1e3a8a; color:#fff; text-align:center;">
            <th style="border-bottom:2px solid #1e40af;">No</th>
            <th style="border-bottom:2px solid #1e40af;">Kode</th>
            <th style="border-bottom:2px solid #1e40af;">Nama</th>
            <th style="border-bottom:2px solid #1e40af;">Kategori</th>
            <th style="border-bottom:2px solid #1e40af;">Satuan</th>
            <th style="border-bottom:2px solid #1e40af;">Stok</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1; 
          while($row = $result->fetch_assoc()): 
              $bg = ($no % 2 == 0) ? '#f1f5f9' : '#fff';
          ?>
            <tr style="
                background: <?= $bg; ?>; 
                text-align:center; 
                transition:background 0.3s;
            "
            onmouseover="this.style.background='#e0e7ff';" 
            onmouseout="this.style.background='<?= $bg; ?>';">
              <td style="border-bottom:1px solid #d1d5db;"><?= $no++; ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['kode_barang']; ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['nama_barang']; ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['kategori']; ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['satuan']; ?></td>
              <td style="border-bottom:1px solid #d1d5db; font-weight:600;"><?= $row['stok']; ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Tombol Export hanya untuk Admin -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
    <div style="margin-top:20px; text-align:right;">
      <a href="export_barang.php" style="
          background:#16a34a; 
          color:#fff; 
          padding:8px 14px; 
          border-radius:8px; 
          text-decoration:none; 
          font-size:14px; 
          font-weight:500;
          margin-left:6px;
          transition:background 0.3s;
      " onmouseover="this.style.background='#15803d';" 
        onmouseout="this.style.background='#16a34a';">
        ⬇️ Export Barang
      </a>
      <a href="export.php" style="
          background:#2563eb; 
          color:#fff; 
          padding:8px 14px; 
          border-radius:8px; 
          text-decoration:none; 
          font-size:14px; 
          font-weight:500;
          margin-left:6px;
          transition:background 0.3s;
      " onmouseover="this.style.background='#1d4ed8';" 
        onmouseout="this.style.background='#2563eb';">
        ⬇️ Export Transaksi
      </a>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
