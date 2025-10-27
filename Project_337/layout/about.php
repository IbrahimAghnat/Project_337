<?php
include 'config/db.php';
include 'layout/header.php';
?>

<div style="
  padding:40px; 
  background:#f9fafb; 
  min-height:calc(100vh - 100px);
  display:flex; 
  flex-direction:column; 
  align-items:center; 
  justify-content:center;
  text-align:center;
">
  <img src="<?= $base_url ?>assets/logo.png" alt="Logo" width="100" style="margin-bottom:20px;">
  <h1 style="font-size:28px; color:#1e3a8a; margin-bottom:10px;">Tentang Sistem Kelola Gudang</h1>
  <p style="max-width:600px; color:#374151; line-height:1.6; font-size:16px;">
    <strong>Kelola Gudang</strong> adalah sistem manajemen gudang pabrik yang dirancang untuk
    mempermudah pengelolaan stok barang, pencatatan barang masuk dan keluar, serta penyusunan laporan stok
    secara cepat, akurat, dan terpusat.
  </p>

  <p style="max-width:600px; color:#4b5563; margin-top:16px; line-height:1.6; font-size:15px;">
    Website ini dikembangkan untuk mendukung efisiensi operasional gudang, 
    mengurangi kesalahan pencatatan manual, serta membantu manajer gudang dalam
    mengambil keputusan berbasis data.
  </p>

  <div style="margin-top:30px; background:#231083; color:#fff; padding:10px 24px; border-radius:20px; font-weight:bold;">
    Versi 1.0 © 2025 - Tim Developer Gudang
  </div>

  <a href="<?= $base_url ?>index.php" style="
    margin-top:20px; 
    display:inline-block; 
    text-decoration:none; 
    color:#1d4ed8; 
    font-weight:bold;
  ">← Kembali ke Beranda</a>
</div>

<?php include 'layout/footer.php'; ?>
