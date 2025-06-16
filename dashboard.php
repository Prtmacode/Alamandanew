<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil jumlah alat dan peminjam
$jumlah_scanner   = (int)mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM alat WHERE kategori='scanner'"))['total'];
$jumlah_monitor   = (int)mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM alat WHERE kategori='monitor'"))['total'];
$jumlah_cpu       = (int)mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM alat WHERE kategori='cpu'"))['total'];
$jumlah_peminjam = (int)mysqli_fetch_assoc(mysqli_query($koneksi, "
  SELECT COUNT(DISTINCT id) as total 
  FROM peminjaman 
  WHERE status != 'Dikembalikan'
"))['total'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="main">
      <?php include 'topbar.php'; ?>

      <!-- Kartu Statistik -->
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

      <!-- Diagram Balok -->
      <section class="chart-section">
        <h3>Statistik Alat & Peminjam</h3>
        <div class="chart-placeholder">
          <canvas id="barChart" width="800" height="300"></canvas>
        </div>
      </section>
    </main>
  </div>

  <script>
    const ctx = document.getElementById('barChart').getContext('2d');

    // Buat gradient satu per satu
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

    const barChart = new Chart(ctx, {
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
