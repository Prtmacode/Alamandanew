<?php
include 'koneksi.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_peminjaman.xls");

$tgl_dari = $_GET['dari'] ?? '';
$tgl_sampai = $_GET['sampai'] ?? '';
$kategori = $_GET['kategori'] ?? '';

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

$result = mysqli_query($koneksi, $query);
?>

<table border="1">
  <thead>
    <tr>
      <th>No</th>
      <th>ID Peminjaman</th>
      <th>Nama Peminjam</th>
      <th>Alat</th>
      <th>Kategori</th>
      <th>Tanggal Pinjam</th>
      <th>Tanggal Kembali</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['id_peminjaman'] ?></td>
        <td><?= $row['peminjam'] ?></td>
        <td><?= $row['merek'] . ' ' . $row['jenis'] ?></td>
        <td><?= $row['kategori'] ?></td>
        <td><?= $row['tanggal_pinjam'] ?></td>
        <td><?= $row['tanggal_kembali'] ?: '-' ?></td>
        <td><?= $row['status'] ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
