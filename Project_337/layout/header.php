<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Sistem Gudang Pabrik</title>
  <style>
    body {
      margin: 0;
      background-color: #d1d5db;
      /* bg-gray-300 */
      font-family: Arial, sans-serif;
      padding-bottom: 60px;
      /* sesuaikan tinggi footer */
    }

    /* ===== HEADER ===== */
    header {
      display: flex;
      align-items: center;
      background: #fff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 8px 16px;
      gap: 16px;
    }

    header button {
      padding: 12px;
      border-radius: 50%;
      border: none;
      background: transparent;
      cursor: pointer;
      transition: background 0.2s;
    }

    header button:hover {
      background: #e5e7eb;
    }

    header button:active {
      background: #d1d5db;
    }

    .logo {
      display: flex;
      align-items: center;
      cursor: pointer;
      border-radius: 6px;
      padding: 4px 8px;
      transition: background 0.2s;
    }

    .logo:hover {
      background: #e5e7eb;
    }

    .logo:active {
      background: #d1d5db;
    }

    .logo img {
      height: 70px;
      width: 70px;
      margin-left: -4px;
    }

    .logo-text {
      margin-left: 8px;
    }

    .logo-text p:first-child {
      font-weight: bold;
      color: #1e3a8a;
    }

    .logo-text p:last-child {
      font-size: 12px;
      color: #4b5563;
    }

    nav.navbar {
      display: flex;
      gap: 8px;
      margin-left: auto;
      font-size: 14px;
      color: #374151;
    }

    /* ===== SIDEBAR ===== */
    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 288px;
      background: #f3f4f6;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
      transform: translateX(-100%);
      transition: transform 0.3s ease;
      z-index: 110;
      overflow-y: auto;
    }

    #sidebar.show {
      transform: translateX(0);
    }

    #sidebar .logo-sidebar {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px 0;
      border-bottom: 1px solid #d1d5db;
    }

    #sidebar .logo-sidebar img {
      width: 70px;
      height: 70px;
    }

    #sidebar .logo-sidebar div {
      margin-left: 8px;
    }

    #sidebar .logo-sidebar p:first-child {
      font-weight: bold;
      font-size: 18px;
    }

    #sidebar .logo-sidebar p:last-child {
      font-size: 14px;
      color: #6b7280;
    }

    #sidebar nav {
      padding: 16px;
    }

    #sidebar nav a {
      display: block;
      padding: 8px 12px;
      border-radius: 6px;
      text-decoration: none;
      color: #111;
      text-align: left;
      margin-bottom: 8px;
      transition: background 0.2s;
    }

    #sidebar nav a:hover {
      background: #e5e7eb;
    }

    #sidebar nav a:active {
      background: #d1d5db;
    }

    #sidebar nav h2 {
      font-weight: bold;
      margin: 16px 0 8px;
    }

    #sidebar nav a.logout {
      background: #fee2e2;
      color: #dc2626;
      font-weight: bold;
    }

    #sidebar nav a.logout:hover {
      background: #fecaca;
    }

    #sidebar nav a.logout:active {
      background: #fca5a5;
    }

    /* ===== OVERLAY ===== */
    #overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 105;
      display: none;
    }

    #overlay.show {
      display: block;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header>
    <!-- Tombol Menu -->
    <button id="menu-btn">
      <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Logo -->
    <div class="logo">
      <img src="../assets/logo.png" alt="Logi">
    </div>
    <div class="logo-text">
      <p>KELOLA GUDANG</p>
      <p>Halo, <?= $_SESSION['username']; ?> (<?= $_SESSION['role']; ?>)</p>
    </div>
  </header>

  <!-- ===== SIDEBAR ===== -->
  <aside id="sidebar">
    <div class="logo-sidebar">
      <img src="../assets/logo.png" alt="Logo">
      <div>
        <p>KELOLA GUDANG</p>
      </div>
    </div>

    <nav style="display:flex; flex-direction:column; gap:10px;">
      <!-- HOME -->
      <a href="../auth/home.php" style="display:flex; align-items:center; gap:8px;">
        <img src="../assets/house.svg" alt="Home" width="29">
        Home
      </a>

      <!-- AKSI -->
      <h2 style="margin-top:10px;">Aksi</h2>
      <a href="../transaksi/masuk.php" style="display:flex; align-items:center; gap:8px;">
        <img src="../assets/in.svg" alt="Barang Masuk" width="29">
        Barang Masuk
      </a>
      <a href="../transaksi/keluar.php" style="display:flex; align-items:center; gap:8px;">
        <img src="../assets/out.svg" alt="Barang Keluar" width="29">
        Barang Keluar
      </a>

      <!-- LAPORAN -->
      <h2 style="margin-top:10px;">Laporan</h2>
      <a href="../barang/index.php" style="display:flex; align-items:center; gap:8px;">
        <img src="../assets/box.svg" alt="Data Barang" width="29">
        Data Barang
      </a>
      <a href="../transaksi/history.php" style="display:flex; align-items:center; gap:8px;">
        <img src="../assets/history.svg" alt="Riwayat" width="29">
        Riwayat
      </a>
      <a href="../laporan/stok.php" style="display:flex; align-items:center; gap:8px;">
        <img src="../assets/report.svg" alt="Laporan Stok" width="29">
        Laporan Stok
      </a>

      <!-- TENTANG (ABOUT) -->
      <hr style="margin:14px 0; border:0; border-top:1px solid #d1d5db;">

      <div style="display:flex; align-items:center; gap:8px; padding:8px 12px;">
        <img src="../assets/info.png" alt="Tentang" width="29">
        <span style="font-weight:500; color:#111;">Tentang</span>
      </div>

      <div style="
  font-size:13px;
  color:#6b7280;
  line-height:1.5;
  padding:8px 12px 16px 12px;
  text-align:justify;
">
        <p><strong>Kelola Gudang</strong> adalah sistem manajemen gudang pabrik yang dirancang untuk
    mempermudah pengelolaan stok barang, pencatatan barang masuk dan keluar, serta penyusunan laporan stok
    secara cepat, akurat, dan terpusat. Website ini dikembangkan untuk mendukung efisiensi operasional gudang, 
    mengurangi kesalahan pencatatan manual, serta membantu manajer gudang dalam
    mengambil keputusan berbasis data.
        </p>
        <p style="margin-top:8px;">
          System 4.0 © 2025<br>
          Dikembangkan oleh Tim Developer Gudang.
        </p>
      </div>

      <!-- LOGOUT -->
      <a href="../auth/logout.php" class="logout" style="text-align:center">
        Logout
      </a>
    </nav>
  </aside>

  <!-- Overlay -->
  <div id="overlay"></div>

  <!-- Script -->
  <script>
    const menuBtn = document.getElementById("menu-btn");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    menuBtn.addEventListener("click", () => {
      sidebar.classList.toggle("show");
      overlay.classList.toggle("show");
    });

    overlay.addEventListener("click", () => {
      sidebar.classList.remove("show");
      overlay.classList.remove("show");
    });
  </script>
</body>

</html>