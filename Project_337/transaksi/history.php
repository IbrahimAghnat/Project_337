<?php
include '../config/db.php';
include '../layout/header.php';

$sql = "SELECT t.*, b.nama_barang, u.username 
        FROM tb_transaksi t 
        JOIN tb_barang b ON t.id_barang = b.id 
        LEFT JOIN tb_users u ON t.id_user = u.id
        ORDER BY t.tanggal DESC";
$result = $conn->query($sql);
?>

<div style="padding:24px;">
  <div style="
      background:#f9fafb; 
      padding:24px; 
      border-radius:12px; 
      box-shadow:0 2px 8px rgba(0,0,0,0.08);
  ">
    <h2 style="
        color:#047857; 
        margin-bottom:40px; 
        text-align:center; 
        font-size:28px;
    ">
      Riwayat Transaksi
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
    table-layout:fixed; /* 👈 tambahkan ini supaya lebar kolom tetap */
">
        <thead>
          <tr style="background:#047857; color:#fff; text-align:center;">
            <th style="border-bottom:2px solid #065f46; width:5%;">ID</th>
            <th style="border-bottom:2px solid #065f46; width:15%;">Barang</th>
            <th style="border-bottom:2px solid #065f46; width:10%;">Jenis</th>
            <th style="border-bottom:2px solid #065f46; width:10%;">Jumlah</th>
            <th style="border-bottom:2px solid #065f46; width:35%;">Keterangan</th> <!-- 👈 kolom lebar -->
            <th style="border-bottom:2px solid #065f46; width:15%;">Tanggal</th>
            <th style="border-bottom:2px solid #065f46; width:10%;">Pekerja</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 0;
          while ($row = $result->fetch_assoc()):
            $no++; ?>
            <tr style="
          background: <?= ($no % 2 == 0) ? '#f0fdf4' : '#fff'; ?>; 
          text-align:center; 
          transition:background 0.3s;
      " onmouseover="this.style.background='#bbf7d0';"
              onmouseout="this.style.background='<?= ($no % 2 == 0) ? '#f0fdf4' : '#fff'; ?>';">
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['id']; ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['nama_barang']; ?></td>
              <td
                style="border-bottom:1px solid #d1d5db; font-weight:600; color:<?= $row['jenis'] == 'masuk' ? '#15803d' : '#dc2626'; ?>">
                <?= $row['jenis'] == 'masuk' ? '📥 Masuk' : '📤 Keluar'; ?>
              </td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['jumlah']; ?></td>
              <td style="
            border-bottom:1px solid #d1d5db; 
            word-wrap:break-word; 
            white-space:normal; 
            text-align:left; 
            vertical-align:top;
        ">
                <?= $row['keterangan']; ?>
              </td>
              <td style="border-bottom:1px solid #d1d5db;"><?= date("d M Y H:i", strtotime($row['tanggal'])); ?></td>
              <td style="border-bottom:1px solid #d1d5db;"><?= $row['username'] ?? '-'; ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../layout/footer.php'; ?>