<?php
include 'koneksi.php';
$kategori = $_GET['kategori'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Alat - Inventaris PT Alamanda</title>

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      overflow-x: hidden;
      background-color: #f8f9fa;
    }

    .navbar-custom {
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      height: 60px;
      background-color: #ffffff;
      border-bottom: 1px solid #dee2e6;
      z-index: 998;
      transition: left 0.3s;
    }

    .navbar-custom.shifted {
      left: 0;
    }

    .navbar-custom .nav-link.active,
    .navbar-custom .nav-link:hover {
      color: #0072ff;
      font-weight: 700;
    }

    #sidebar {
      width: 250px;
      height: 100vh;
      background-color: #e2e2e2;
      position: fixed;
      top: 0;
      left: 0;
      padding: 1.5rem 1rem;
      transition: all 0.3s;
      z-index: 1000;
    }
    #sidebar.hide {
      left: -260px;
    }
    #sidebar .logo {
      text-align: center;
      margin-bottom: 2rem;
    }
    #sidebar .logo img {
      max-width: 150px;
      height: auto;
    }
    .nav-btn {
      display: block;
      width: 100%;
      margin: 0.5rem 0;
      padding: 0.75rem;
      background-color: #ffffff;
      color: #0072ff;
      border-radius: 8px;
      text-align: left;
      font-weight: 700;
      transition: all 0.2s ease-in-out;
      text-decoration: none;
    }
    .nav-btn:hover {
      background-color: #0072ff;
      color: #ffffff;
    }
    #hamburger {
      position: fixed;
      top: 1rem;
      left: 1rem;
      z-index: 1100;
      background: #fff;
      border: none;
      padding: 0.3rem 0.5rem;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    #hamburger i {
      font-size: 1.2rem;
    }
    #content {
      margin-left: 250px;
      padding-top: 80px;
      transition: margin-left 0.3s;
    }

    #sidebar.hide + .navbar-custom {
      left: 0;
    }

    #sidebar.hide + .navbar-custom + #content {
      margin-left: 0;
    }

    .btn-kategori {
      flex: 1;
      min-width: 180px;
      height: 100px;
      font-size: 1.2rem;
      font-weight: 600;
      border-radius: 12px;
      color: #fff;
      text-decoration: none;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease-in-out;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border: none;
      transform: scale(1);
    }
    .btn-kategori i {
      font-size: 2rem;
      margin-bottom: 0.4rem;
    }
    .btn-kategori:active {
      transform: scale(0.95);
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2) inset;
    }
    .btn-kategori:hover {
      filter: brightness(1.05);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .btn-scanner { background: linear-gradient(135deg, #00c6ff, #0072ff); }
    .btn-scanner.active, .btn-scanner:hover { background: linear-gradient(135deg, #0072ff, #004eaa); }
    .btn-cpu { background: linear-gradient(135deg, #8e2de2, #4a00e0); }
    .btn-cpu.active, .btn-cpu:hover { background: linear-gradient(135deg, #6a00b7, #320088); }
    .btn-monitor { background: linear-gradient(135deg, #43e97b, #38f9d7); color: #000; }
    .btn-monitor.active, .btn-monitor:hover { background: linear-gradient(135deg, #32c86e, #2ddfcb); color: #000; }

    table th, table td {
      vertical-align: middle !important;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom px-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-primary ms-4" href="alat.php">Alat</a>
    <div class="ms-auto d-flex align-items-center">
      <form class="d-flex me-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Cari sesuatu..." aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Cari</button>
      </form>
      <a href="login.php" class="btn btn-success">
        <i class="bi bi-box-arrow-in-right me-1"></i> Login
      </a>
    </div>
  </div>
</nav>

<!-- Hamburger Button -->
<button id="hamburger"><i class="bi bi-list"></i></button>

<!-- Sidebar -->
<div id="sidebar">
  <div class="logo">
    <img src="assets/img/logo-alamanda.png" alt="Logo Alamanda" />
  </div>
  <a href="index.php" class="nav-btn"><i class="bi bi-house-door-fill me-2"></i> Home</a>
  <a href="alat_user.php" class="nav-btn"><i class="bi bi-tools me-2"></i> Alat</a>
</div>

<!-- Konten -->
<div id="content">
  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Sukses!</strong> Data alat berhasil ditambahkan.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
  <?php endif; ?>

  <div class="mb-4 d-flex flex-wrap gap-3 justify-content-start">
    <a href="alat_user.php?kategori=scanner" class="btn-kategori btn-scanner <?= ($kategori === 'scanner') ? 'active' : '' ?>">
      <i class="bi bi-upc-scan"></i> Scanner
    </a>
    <a href="alat_user.php?kategori=cpu" class="btn-kategori btn-cpu <?= ($kategori === 'cpu') ? 'active' : '' ?>">
      <i class="bi bi-cpu"></i> CPU
    </a>
    <a href="alat_user.php?kategori=monitor" class="btn-kategori btn-monitor <?= ($kategori === 'monitor') ? 'active' : '' ?>">
      <i class="bi bi-display"></i> Monitor
    </a>
  </div>

  <div class="table-responsive bg-white p-3 rounded shadow-sm">
    <?php include 'tabel_alat.php'; ?>
  </div>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
  <div id="notifToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body d-flex align-items-center gap-2">
        <i id="toastIcon" class="bi"></i>
        <span id="toastMessage">Notifikasi</span>
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
    </div>
  </div>
</div>

<script>
  const sidebar = document.getElementById('sidebar');
  const hamburger = document.getElementById('hamburger');
  const content = document.getElementById('content');

  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('hide');
    content.classList.toggle('full-width');
  });

  const params = new URLSearchParams(window.location.search);
  const toastEl = document.getElementById('notifToast');
  const toast = new bootstrap.Toast(toastEl);
  const toastMessage = document.getElementById('toastMessage');
  const toastIcon = document.getElementById('toastIcon');

  if (params.has('success') || params.has('msg')) {
    let msg = '';
    let icon = 'bi-info-circle';
    let bg = 'text-bg-primary';

    if (params.get('success') === '1') {
      msg = '✅ Data alat berhasil ditambahkan!';
      icon = 'bi-check-circle-fill';
      bg = 'text-bg-success';
    } else if (params.get('msg') === 'edit_sukses') {
      msg = '✏️ Data berhasil diperbarui.';
      icon = 'bi-pencil-square';
      bg = 'text-bg-success';
    } else if (params.get('msg') === 'hapus_sukses') {
      msg = '🗑️ Data berhasil dihapus.';
      icon = 'bi-trash3-fill';
      bg = 'text-bg-success';
    } else if (params.get('msg') === 'hapus_gagal') {
      msg = '❌ Gagal menghapus data.';
      icon = 'bi-x-circle-fill';
      bg = 'text-bg-danger';
    }

    toastEl.className = `toast align-items-center border-0 ${bg}`;
    toastIcon.className = `bi ${icon} fs-5`;
    toastMessage.textContent = msg;
    toast.show();
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
