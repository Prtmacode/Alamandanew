<?php
include 'koneksi.php';

// Ambil dan sanitasi input
$tgl_dari   = isset($_GET['dari']) ? mysqli_real_escape_string($koneksi, $_GET['dari']) : '';
$tgl_sampai = isset($_GET['sampai']) ? mysqli_real_escape_string($koneksi, $_GET['sampai']) : '';
$kategori   = isset($_GET['kategori']) ? mysqli_real_escape_string($koneksi, $_GET['kategori']) : '';

// Bangun query
$query = "SELECT p.*, a.jenis, a.kategori, a.merek 
          FROM peminjaman p 
          JOIN alat a ON p.id_alat = a.id_alat 
          WHERE 1";

if (!empty($tgl_dari) && !empty($tgl_sampai)) {
  $query .= " AND p.tanggal_pinjam BETWEEN '$tgl_dari' AND '$tgl_sampai'";
}

if (!empty($kategori)) {
  $query .= " AND a.kategori = '$kategori'";
}

$query .= " ORDER BY p.tanggal_pinjam DESC";

// Eksekusi query
$result = mysqli_query($koneksi, $query);
if (!$result) {
  die("Query gagal: " . mysqli_error($koneksi));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Peminjaman</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    .form-filter {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
    .form-filter label {
      font-weight: 500;
      display: block;
      margin-bottom: 6px;
    }
    .form-filter input, .form-filter select {
      padding: 8px 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      min-width: 180px;
    }
    .btn-group a {
      background: #28a745;
      color: white;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 6px;
      margin-right: 10px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    .btn-group a i {
      font-size: 16px;
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .data-table th, .data-table td {
      padding: 12px 16px;
      border-bottom: 1px solid #eee;
      text-align: left;
    }
    .data-table th {
      background: #f1f1f1;
    }
    .status-pinjam {
      background: #f39c12;
      color: white;
      padding: 4px 10px;
      border-radius: 4px;
      font-size: 12px;
    }
    .status-kembali {
      background: #2ecc71;
      color: white;
      padding: 4px 10px;
      border-radius: 4px;
      font-size: 12px;
    }
  </style>
</head>
<body>
<div class="container">
<?php $page_title = "Laporan"; ?>
  <?php include 'sidebar.php'; ?>
  <main class="main">
    <?php include 'topbar.php'; ?>

    <form method="GET" class="form-filter">
      <div>
        <label>Dari Tanggal</label>
        <input type="date" name="dari" value="<?= htmlspecialchars($tgl_dari) ?>">
      </div>
      <div>
        <label>Sampai Tanggal</label>
        <input type="date" name="sampai" value="<?= htmlspecialchars($tgl_sampai) ?>">
      </div>
      <div>
        <label>Kategori</label>
        <select name="kategori">
          <option value="">-- Semua --</option>
          <option value="scanner" <?= $kategori === 'scanner' ? 'selected' : '' ?>>Scanner</option>
          <option value="monitor" <?= $kategori === 'monitor' ? 'selected' : '' ?>>Monitor</option>
          <option value="cpu" <?= $kategori === 'cpu' ? 'selected' : '' ?>>CPU</option>
        </select>
      </div>
      <div style="align-self: flex-end;">
        <button type="submit" class="btn-tambah"><i class="ri-filter-line"></i> Filter</button>
      </div>
    </form>

    <div class="btn-group" style="margin-bottom: 20px;">
      <a href="export_pdf.php?dari=<?= urlencode($tgl_dari) ?>&sampai=<?= urlencode($tgl_sampai) ?>&kategori=<?= urlencode($kategori) ?>" target="_blank">
        <i class="ri-file-pdf-line"></i> Cetak PDF
      </a>
      <a href="export_excel.php?dari=<?= urlencode($tgl_dari) ?>&sampai=<?= urlencode($tgl_sampai) ?>&kategori=<?= urlencode($kategori) ?>" target="_blank">
        <i class="ri-file-excel-2-line"></i> Export Excel
      </a>
    </div>

    <div class="table-container">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Peminjam</th>
            <th>Alat</th>
            <th>Kategori</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $row['id_peminjaman'] ?></td>
                <td><?= htmlspecialchars($row['peminjam']) ?></td>
                <td><?= htmlspecialchars($row['merek'] . ' ' . $row['jenis']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= $row['tanggal_pinjam'] ?></td>
                <td><?= $row['tanggal_kembali'] ?: '-' ?></td>
                <td>
                  <span class="<?= $row['status'] === 'Dipinjam' ? 'status-pinjam' : 'status-kembali' ?>">
                    <?= $row['status'] ?>
                  </span>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="7" style="text-align:center;">Tidak ada data.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
</body>
</html>
