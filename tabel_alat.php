<?php
include 'koneksi.php';

$kategori = $_GET['kategori'] ?? '';

// Query semua alat jika kategori kosong
if ($kategori) {
  $query = mysqli_query($koneksi, "SELECT * FROM alat WHERE kategori = '$kategori' ORDER BY id_alat ASC");
} else {
  $query = mysqli_query($koneksi, "SELECT * FROM alat ORDER BY kategori, id_alat ASC");
}
?>

<table class="table table-bordered table-striped align-middle">
  <thead class="table-light">
    <tr>
      <th>ID Alat</th>
      <th>Kategori</th>
      <th>Jenis</th>
      <th>Merek</th>
      <th>Ukuran</th>
      
  </thead>
  <tbody>
    <?php if (mysqli_num_rows($query) > 0): ?>
      <?php while ($data = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= htmlspecialchars($data['id_alat']); ?></td>
          <td><?= htmlspecialchars(ucfirst($data['kategori'])); ?></td>
          <td><?= htmlspecialchars($data['jenis']); ?></td>
          <td><?= htmlspecialchars($data['merek']); ?></td>

          <!-- Ukuran -->
          <td>
            <?php
              if ($data['kategori'] === 'scanner') {
                echo htmlspecialchars($data['ukuran'] ?? '-');
              } elseif ($data['kategori'] === 'monitor') {
                echo htmlspecialchars($data['ukuran_inch'] . ' inch' ?? '-');
              } else {
                echo '-';
              }
            ?>
          </td>

          <!-- Spesifikasi -->
          <td>
            <?php
              if ($data['kategori'] === 'cpu' || $data['kategori'] === 'monitor') {
                echo nl2br(htmlspecialchars($data['spesifikasi'] ?? '-'));
              } else {
                echo '-';
              }
            ?>
          </td>

          <td><?= htmlspecialchars($data['status']); ?></td>
          <td><?= (int)$data['jumlah_pemakaian']; ?></td>
          <td><?= htmlspecialchars($data['lokasi'] ?? '-'); ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="9" class="text-center text-muted">
          Tidak ada data untuk kategori <strong><?= htmlspecialchars($kategori); ?></strong>.
        </td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
