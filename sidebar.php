<!-- sidebar.php -->
<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <img src="assets/img/logo-alamanda.png" alt="Logo" class="logo">
    <button id="sidebarToggle" class="hamburger" aria-label="Toggle Sidebar">
      <i class="ri-menu-line"></i>
    </button>
  </div>
  <nav>
    <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
      <i class="ri-home-5-fill"></i> <span class="link-text">Dashboard</span>
    </a>
    <a href="alat.php" class="<?= $currentPage == 'alat.php' ? 'active' : '' ?>">
      <i class="ri-computer-line"></i> <span class="link-text">Alat</span>
    </a>
    <a href="peminjaman.php" class="<?= $currentPage == 'peminjaman.php' ? 'active' : '' ?>">
      <i class="ri-edit-box-line"></i> <span class="link-text">Peminjaman</span>
    </a>
    <a href="pengembalian.php" class="<?= $currentPage == 'pengembalian.php' ? 'active' : '' ?>">
      <i class="ri-bar-chart-box-line"></i> <span class="link-text">Pengembalian</span>
    </a>
    <a href="laporan.php" class="<?= $currentPage == 'laporan.php' ? 'active' : '' ?>">
      <i class="ri-file-list-3-line"></i> <span class="link-text">Laporan</span>
    </a>
  </nav>
  <button class="logout-btn"><i class="ri-logout-box-line"></i> <span class="link-text">Log Out</span></button>
</aside>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");

    toggleButton.addEventListener("click", function () {
      sidebar.classList.toggle("sidebar-collapsed");
    });
  });
</script>
