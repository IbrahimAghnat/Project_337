<?php
include '../config/db.php';
include '../layout/header.php';

// Fungsi ambil jumlah data dengan validasi
function getCount($conn, $sql)
{
  $result = $conn->query($sql);
  if (!$result) {
    die("Query gagal: " . $conn->error);
  }
  return (int) $result->fetch_assoc()['jml'];
}

// Ambil jumlah data
$barang = getCount($conn, "SELECT COUNT(*) AS jml FROM tb_barang");
$masuk = getCount($conn, "SELECT COUNT(*) AS jml FROM tb_transaksi WHERE jenis='masuk'");
$keluar = getCount($conn, "SELECT COUNT(*) AS jml FROM tb_transaksi WHERE jenis='keluar'");
?>

<div style="padding:24px;">
  <div style="padding:24px; border-radius:12px;">
    <h2 style="
      color:#001756ff;
      margin-bottom:20px;
      text-align:center;
      font-size:30px;
    ">
      Dashboard <?= isset($_SESSION["role"]) ? ucfirst($_SESSION["role"]) : "User"; ?>
    </h2>

    <p style="text-align:center; margin-bottom:40px; font-size:16px; color:#374151;">
      Selamat datang di sistem kelola gudang pabrik.
    </p>

    <!-- Flexbox utama -->
    <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:20px;">
      <!-- Barang Masuk -->
      <a href="../transaksi/masuk.php" style="
        flex:1; min-width:200px; background:#fff; padding:20px; border-radius:12px;
        border:4px solid #006838ff; box-shadow:0 4px 10px rgba(0,0,0,0.08);
        text-align:center; text-decoration:none; color:inherit;
        transition:transform 0.2s, box-shadow 0.2s;
      " 
      onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 6px 14px rgba(0,0,0,0.15)'"
      onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.08)'">
        <img src="../assets/in.svg" alt="Barang Masuk" width="43" style="margin-bottom:8px;">
        <h3 style="margin:10px 0; font-size:18px; color:#14532d;">Barang Masuk</h3>
        <p style="font-size:20px; font-weight:bold; color:#16a34a;"><?= $masuk; ?></p>
      </a>

      <!-- Data Barang -->
      <a href="../barang/index.php" style="
        flex:1; min-width:200px; background:#fff; padding:20px; border-radius:12px;
        border:4px solid #231083ff; box-shadow:0 4px 10px rgba(0,0,0,0.08);
        text-align:center; text-decoration:none; color:inherit;
        transition:transform 0.2s, box-shadow 0.2s;
      " 
      onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 6px 14px rgba(0,0,0,0.15)'"
      onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.08)'">
        <img src="../assets/box.svg" alt="Data Barang" width="43" style="margin-bottom:8px;">
        <h3 style="margin:10px 0; font-size:18px; color:#0c4a6e;">Data Barang</h3>
        <p style="font-size:20px; font-weight:bold; color:#1d4ed8;"><?= $barang; ?></p>
      </a>

      <!-- Barang Keluar -->
      <a href="../transaksi/keluar.php" style="
        flex:1; min-width:200px; background:#fff; padding:20px; border-radius:12px;
        border:4px solid #770000ff; box-shadow:0 4px 10px rgba(0,0,0,0.08);
        text-align:center; text-decoration:none; color:inherit;
        transition:transform 0.2s, box-shadow 0.2s;
      " 
      onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 6px 14px rgba(0,0,0,0.15)'"
      onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.08)'">
        <img src="../assets/out.svg" alt="Barang Keluar" width="43" style="margin-bottom:8px;">
        <h3 style="margin:10px 0; font-size:18px; color:#7f1d1d;">Barang Keluar</h3>
        <p style="font-size:20px; font-weight:bold; color:#dc2626;"><?= $keluar; ?></p>
      </a>
    </div>
  </div>

  <!-- Tabel User (khusus admin) -->
  <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"):
    $data_user = $conn->query("SELECT * FROM tb_users");
  ?>
    <div style="padding:24px; margin-top:16px;">
      <h3 style="color:#00113fff; margin:20px 0 40px; text-align:center; font-size:25px;">
        Tabel User
      </h3>

      <div style="margin-bottom:20px; text-align:right;">
        <a href="register.php" style="
          background:#001f72ff; color:#fff; padding:10px 16px; border-radius:8px;
          text-decoration:none; font-weight:600; transition:background 0.3s;
        " onmouseover="this.style.background='#591078ff';" onmouseout="this.style.background='#001f72ff';">
          ➕ Tambah User
        </a>
      </div>

      <div style="
        background:#fff; border-radius:6px; border:1px solid #e5e7eb;
        box-shadow:0 2px 6px rgba(0,0,0,0.05); overflow:hidden;
      ">
        <table cellpadding="12" cellspacing="0" style="
          width:100%; border-collapse:collapse; font-size:15px;
          border:2px solid #002e66ff;
        ">
          <thead>
            <tr style="background:#002385ff; color:#fff; text-align:center;">
              <th>No</th>
              <th>ID</th>
              <th>Nama</th>
              <th>Peran</th>
              <th>Tanggal Login</th>
              <th style="width:25%;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while ($row = $data_user->fetch_assoc()):
            ?>
              <tr style="text-align:center; transition:background 0.3s;"
                onmouseover="this.style.background='#f1f5f9';"
                onmouseout="this.style.background='#ffffff';">
                <td style="font-weight:bold; color:#1e40af;"><?= $no++; ?></td>
                <td><?= $row['id']; ?></td>
                <td style="font-weight:600;"><?= $row['username']; ?></td>
                <td style="color:#1e40af;"><?= ucfirst($row['role']); ?></td>
                <td><?= $row['tanggal_login']; ?></td>
                <td>
                  <a href="delete.php?id=<?= $row['id']; ?>" 
                    style="color:#dc2626; font-weight:600; text-decoration:none;"
                    onclick="return confirm('Yakin ingin menghapus user ini?');">
                    ❌ Hapus
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php include '../layout/footer.php'; ?>
