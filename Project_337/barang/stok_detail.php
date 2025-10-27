<?php
include '../config/db.php';
include '../layout/header.php';

$id_barang = $_GET['id']; 

$barang = $conn->query("SELECT * FROM tb_barang WHERE id=$id_barang")->fetch_assoc();

$detail = $conn->query("SELECT * FROM tb_stok_detail 
                        WHERE id_barang=$id_barang 
                        ORDER BY tanggal_expired ASC");
?>

<div style="padding:24px;">
  <div style="
      background:#f9fafb; 
      padding:24px; 
      border-radius:12px; 
      box-shadow:0 2px 8px rgba(0,0,0,0.08);
  ">
    <h2 style="
        color:#1d4ed8; 
        margin-bottom:16px; 
        font-size:26px; 
        text-align:center;
    ">
      Stok Detail Barang
    </h2>

    <p style="margin-bottom:20px; font-size:16px; color:#374151;">
      <b>Kode:</b> <?= $barang['kode_barang']; ?><br>
      <b>Nama:</b> <?= $barang['nama_barang']; ?><br>
      <b>Total Stok:</b> <?= $barang['stok']; ?>
    </p>

    <?php if ($barang['stok'] > 0) { ?>
      <div style="
          background:#fff; 
          border-radius:10px; 
          border:1px solid #e5e7eb; 
          box-shadow:0 2px 6px rgba(0,0,0,0.05); 
          overflow:hidden;
          margin-bottom:20px;
      ">
        <table cellpadding="12" cellspacing="0" style="width:100%; border-collapse:separate; border-spacing:0; font-size:15px;">
          <thead>
            <tr style="background:linear-gradient(to right, #1d4ed8, #2563eb); color:#fff; text-align:center;">
              <th style="border-bottom:2px solid #1e3a8a;">ID Batch</th>
              <th style="border-bottom:2px solid #1e3a8a;">Jumlah</th>
              <th style="border-bottom:2px solid #1e3a8a;">Tanggal Expired</th>
              <th style="border-bottom:2px solid #1e3a8a;">Tanggal Input</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $detail->fetch_assoc()): 
              // Tambahkan pengecekan agar hanya menampilkan jumlah > 0
              if ($row['jumlah'] == 0) continue;

              $gradient = "linear-gradient(to right, #eef2ff, #e0f2fe)";
            ?>
              <tr style="
                  background: <?= $gradient ?>; 
                  text-align:center; 
                  transition:background 0.3s;
              "
              onmouseover="this.style.background='linear-gradient(to right,#bfdbfe,#93c5fd)';" 
              onmouseout="this.style.background='<?= $gradient ?>';">
                <td style="border-bottom:1px solid #d1d5db;"><?= $row['id']; ?></td>
                <td style="border-bottom:1px solid #d1d5db; font-weight:600; color:#1e40af;">
                  <?= $row['jumlah']; ?>
                </td>
                <td style="border-bottom:1px solid #d1d5db; 
                  <?php if(strtotime($row['tanggal_expired']) < time()){ echo "color:red;font-weight:bold;"; } ?>">
                  <?= $row['tanggal_expired']; ?>
                </td>
                <td style="border-bottom:1px solid #d1d5db;"><?= $row['tanggal_input']; ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php } ?>

    <div style="text-align:center;">
      <a href="index.php" style="
          background:#1d4ed8; 
          color:#fff; 
          padding:10px 16px; 
          border-radius:8px; 
          text-decoration:none; 
          font-weight:600;
          transition:background 0.3s;
      " 
      onmouseover="this.style.background='#2563eb';" 
      onmouseout="this.style.background='#1d4ed8';">
        ⬅️ Kembali ke Data Barang
      </a>
    </div>
  </div>
</div>

<?php include '../layout/footer.php'; ?>
