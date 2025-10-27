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
        color:#4338ca; 
        margin-bottom:40px; 
        text-align:center; 
        font-size:28px;
    ">
      Data Barang
    </h2>

    <?php if ($_SESSION["role"] == "admin") { ?>
      <div style="margin-bottom:16px; text-align:right;">
        <a href="add.php" style="
            background:#4338ca; 
            color:#fff; 
            padding:8px 14px; 
            border-radius:8px; 
            text-decoration:none; 
            font-size:14px; 
            font-weight:500;
            transition:background 0.3s;
        " onmouseover="this.style.background='#3730a3';" 
          onmouseout="this.style.background='#4338ca';">
          ➕ Tambah Barang
        </a>
      </div>
    <?php } ?>

    <div style="
        background:#fff; 
        border-radius:10px; 
        box-shadow:0 1px 4px rgba(0,0,0,0.1); 
        overflow:hidden;
    ">
      <table cellpadding="12" cellspacing="0" style="
          width:100%; 
          border-collapse:separate; 
          border-spacing:0; 
          font-size:15px;
      ">
        <thead>
          <tr style="background:#4338ca; color:#fff; text-align:center;">
            <th style="border-bottom:2px solid #3730a3;">No</th>
            <th style="border-bottom:2px solid #3730a3;">Kode</th>
            <th style="border-bottom:2px solid #3730a3;">Nama</th>
            <th style="border-bottom:2px solid #3730a3;">Kategori</th>
            <th style="border-bottom:2px solid #3730a3;">Satuan</th>
            <th style="border-bottom:2px solid #3730a3;">Stok</th>
            <th style="border-bottom:2px solid #3730a3;">Tanggal Input</th>

            <?php if ($_SESSION["role"] == "admin") { ?>
              <th style="border-bottom:2px solid #3730a3; width:28%;">Aksi</th>
            <?php } elseif ($_SESSION["role"] == "user" || $_SESSION["role"] == "staff") { ?>
              <th style="border-bottom:2px solid #3730a3; width:12%;">Aksi</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1; 
          while($row = $result->fetch_assoc()): 
              $bgColor = ($no % 2 == 0) ? '#f3f4f6' : '#fff'; 
          ?>
            <tr style="
                background: <?= $bgColor ?>; 
                text-align:center; 
                transition:background 0.3s;
            "
            onmouseover="this.style.background='#e0e7ff';" 
            onmouseout="this.style.background='<?= $bgColor ?>';">
              <td style="border-bottom:1px solid #d1d5db;"><?= $no++; ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['kode_barang']; ?></td>
              <td style="border-bottom:1px solid #d1d5db; font-weight:500;"><?= $row['nama_barang']; ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['kategori']; ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['satuan']; ?></td>
              <td style="border-bottom:1px solid #d1d5db; font-weight:600;"><?= $row['stok']; ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= date("d M Y", strtotime($row['tanggal_input'])); ?></td>
              
              <?php if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "user" || $_SESSION["role"] == "staff") { ?>
                <td style="border-bottom:1px solid #d1d5db;">
                  <!-- Semua role (admin, user, staff) bisa lihat -->
                  <a href="stok_detail.php?id=<?= $row['id']; ?>" style="color:#2563eb; text-decoration:none; margin:0 6px;">🔍 Lihat</a>
                  
                  <!-- Hanya admin yang bisa edit & hapus -->
                  <?php if ($_SESSION["role"] == "admin") { ?>
                    <a href="edit.php?id=<?= $row['id']; ?>" style="color:#047857; text-decoration:none; margin:0 6px;">✏️ Edit</a>
                    <a href="delete.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin?')" style="color:#dc2626; text-decoration:none; margin:0 6px;">🗑️ Hapus</a>
                  <?php } ?>
                </td>
              <?php } ?>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
