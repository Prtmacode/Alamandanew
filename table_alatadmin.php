<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

$kategori = $_GET['kategori'] ?? '';

// Ambil semua data jika kategori kosong
if ($kategori) {
  $query = mysqli_query($koneksi, "SELECT * FROM alat WHERE kategori='$kategori' ORDER BY id_alat ASC");
} else {
  $query = mysqli_query($koneksi, "SELECT * FROM alat ORDER BY kategori, id_alat ASC");
}
?>

<?php if (mysqli_num_rows($query) > 0): ?>
  <table class="data-table">
    <thead>
      <tr>
        <th>ID Alat</th>
        <th>Kategori</th>
        <th>Jenis</th>
        <th>Merek</th>
        <th>Ukuran</th>
        <th>Spesifikasi</th>
        <th>Status</th>
        <th>Jumlah Pemakaian</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= htmlspecialchars($row['id_alat']) ?></td>
          <td><?= htmlspecialchars(ucfirst($row['kategori'])) ?></td>
          <td><?= htmlspecialchars($row['jenis']) ?></td>
          <td><?= htmlspecialchars($row['merek']) ?></td>

          <!-- Ukuran -->
          <td>
            <?php
              if ($row['kategori'] === 'scanner') {
                echo htmlspecialchars($row['ukuran'] ?? '-');
              } elseif ($row['kategori'] === 'monitor') {
                echo htmlspecialchars($row['ukuran_inch'] . ' inch' ?? '-');
              } else {
                echo '-';
              }
            ?>
          </td>

          <!-- Spesifikasi -->
          <td>
            <?php
              if ($row['kategori'] === 'cpu' || $row['kategori'] === 'monitor') {
                echo nl2br(htmlspecialchars($row['spesifikasi'] ?? '-'));
              } else {
                echo '-';
              }
            ?>
          </td>

          <td><?= htmlspecialchars($row['status']) ?></td>
          <td><?= (int)$row['jumlah_pemakaian'] ?></td>
          <td>
            <a href="alat.php?kategori=<?= urlencode($kategori) ?>&edit=<?= $row['id_alat'] ?>" class="btn-edit">
              <i class="ri-edit-line"></i>
            </a>
            <a href="alat.php?kategori=<?= urlencode($kategori) ?>&hapus=<?= $row['id_alat'] ?>" onclick="return confirm('Yakin ingin menghapus alat ini?')" class="btn-hapus">
              <i class="ri-delete-bin-line"></i>
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

<?php else: ?>
  <p class="text-muted">
    Tidak ada data alat <?= $kategori ? "untuk kategori <strong>" . htmlspecialchars($kategori) . "</strong>" : "yang tersedia." ?>
  </p>
<?php endif; ?>
