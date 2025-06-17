<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data statistik
$jumlah_scanner   = (int)mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM alat WHERE kategori='scanner'"))['total'];
$jumlah_monitor   = (int)mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM alat WHERE kategori='monitor'"))['total'];
$jumlah_cpu       = (int)mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM alat WHERE kategori='cpu'"))['total'];
$jumlah_peminjam  = (int)mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT id) as total FROM peminjaman WHERE status != 'Dikembalikan'"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/sidebar1.css">

  <!-- Icons & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  <!-- Hamburger Button -->
  <button id="hamburger"><i class="bi bi-list"></i></button>

  <!-- Sidebar -->
  <?php include 'sidebar1.php'; ?>

  <!-- Main Content -->
  <main class="main" id="mainContent">
    <?php include 'topbar.php'; ?>

    <!-- Statistik Kartu -->
    <section class="dashboard-cards">
      <div class="card scanner">
        <i class="ri-printer-line"></i>
        <p>Scanner</p>
        <h2><?= $jumlah_scanner ?></h2>
      </div>
      <div class="card monitor">
        <i class="ri-tv-line"></i>
        <p>Monitor</p>
        <h2><?= $jumlah_monitor ?></h2>
      </div>
      <div class="card cpu">
        <i class="ri-database-2-line"></i>
        <p>CPU</p>
        <h2><?= $jumlah_cpu ?></h2>
      </div>
      <div class="card total">
        <i class="ri-user-3-fill"></i>
        <p>Total Peminjam</p>
        <h2><?= $jumlah_peminjam ?></h2>
      </div>
    </section>

    <!-- Chart Section -->
    <section class="chart-section">
      <h3>Statistik Alat & Peminjam</h3>
      <div class="chart-placeholder">
        <canvas id="barChart" width="800" height="300"></canvas>
      </div>
    </section>
  </main>

  <!-- JS for Sidebar Toggle -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.getElementById('hamburger');
    const main = document.getElementById('mainContent');

    hamburger.addEventListener('click', () => {
      sidebar.classList.toggle('hide');
      sidebar.classList.toggle('show');
      main.classList.toggle('full');
    });
  </script>

  <!-- Chart.js Script -->
  <script>
    const ctx = document.getElementById('barChart').getContext('2d');

    const gradientScanner = ctx.createLinearGradient(0, 0, 400, 0);
    gradientScanner.addColorStop(0, '#6dd5fa');
    gradientScanner.addColorStop(1, '#2980b9');

    const gradientMonitor = ctx.createLinearGradient(0, 0, 400, 0);
    gradientMonitor.addColorStop(0, '#f7b733');
    gradientMonitor.addColorStop(1, '#fc4a1a');

    const gradientCPU = ctx.createLinearGradient(0, 0, 400, 0);
    gradientCPU.addColorStop(0, '#e96443');
    gradientCPU.addColorStop(1, '#904e95');

    const gradientPeminjam = ctx.createLinearGradient(0, 0, 400, 0);
    gradientPeminjam.addColorStop(0, '#56ab2f');
    gradientPeminjam.addColorStop(1, '#a8e063');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Scanner', 'Monitor', 'CPU', 'Peminjam'],
        datasets: [{
          label: 'Jumlah',
          data: [
            <?= $jumlah_scanner ?>,
            <?= $jumlah_monitor ?>,
            <?= $jumlah_cpu ?>,
            <?= $jumlah_peminjam ?>
          ],
          backgroundColor: [
            gradientScanner,
            gradientMonitor,
            gradientCPU,
            gradientPeminjam
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Jumlah Alat & Peminjam'
          },
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            precision: 0
          }
        }
      }
    });
  </script>

</body>
</html>
