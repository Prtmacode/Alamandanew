<?php
include 'koneksi.php';

// Proses pengembalian alat
if (isset($_GET['kembali'])) {
  $id = $_GET['kembali'];
  $tgl_kembali = date('Y-m-d');

  // Ambil id_alat dari peminjaman
  $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_alat FROM peminjaman WHERE id='$id'"));
  $id_alat = $data['id_alat'];

  // Update status peminjaman dan tanggal kembali
  mysqli_query($koneksi, "UPDATE peminjaman SET status='Dikembalikan', tanggal_kembali='$tgl_kembali' WHERE id='$id'");

  // Update status alat ke Tersedia
  mysqli_query($koneksi, "UPDATE alat SET status='Tersedia' WHERE id_alat='$id_alat'");

  // Tambah jumlah pemakaian alat +1
  mysqli_query($koneksi, "UPDATE alat SET jumlah_pemakaian = jumlah_pemakaian + 1 WHERE id_alat = '$id_alat'");

  header("Location: pengembalian.php?returned=1");
  exit();
}

// Ambil data peminjaman yang masih 'Dipinjam'
$query = mysqli_query($koneksi, "SELECT p.*, a.id_alat, a.kategori, a.jenis, a.merek, a.seri 
  FROM peminjaman p 
  JOIN alat a ON p.id_alat = a.id_alat 
  WHERE p.status='Dipinjam' 
  ORDER BY p.tanggal_pinjam DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengembalian Alat</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
<div class="container">
<?php $page_title = "Pengembalian";  ?>  
<?php include 'sidebar.php'; ?>
  <main class="main">
    <?php include 'topbar.php'; ?>

    <div class="table-container">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Peminjam</th>
            <th>ID Alat</th>
            <th>Kategori</th>
            <th>Merek</th>
            <th>Seri</th>
            <th>Jenis</th>
            <th>Tgl Pinjam</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
              <td><?= $row['id_peminjaman'] ?></td>
              <td><?= htmlspecialchars($row['peminjam']) ?></td>
              <td><?= htmlspecialchars($row['id_alat']) ?></td>
              <td><?= htmlspecialchars(ucfirst($row['kategori'])) ?></td>
              <td><?= htmlspecialchars($row['merek']) ?></td>
              <td><?= htmlspecialchars($row['seri']) ?></td>
              <td><?= htmlspecialchars($row['jenis']) ?></td>
              <td><?= $row['tanggal_pinjam'] ?></td>
              <td><span class="status status-pinjam"><?= $row['status'] ?></span></td>
              <td>
                <a href="pengembalian.php?kembali=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin mengembalikan alat ini?')" class="btn-icon text-blue">
                  <i class="ri-checkbox-circle-line"></i> Kembalikan
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    if (params.get('returned')) alert("Alat berhasil dikembalikan!");
  });
</script>
</body>
</html>
