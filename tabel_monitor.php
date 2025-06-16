<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM alat WHERE kategori='monitor' ORDER BY id_alat ASC");
?>

<?php if (mysqli_num_rows($query) > 0): ?>
  <table class="data-table">
    <thead>
      <tr>
        <th>ID Alat</th>
        <th>Seri</th> <!-- Ganti dari Jenis -->
        <th>Merek</th>
        <th>Ukuran Inci</th>
        <th>Spesifikasi</th>
        <th>Status</th>
        <th>Jumlah Pemakaian</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($data = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= htmlspecialchars($data['id_alat']) ?></td>
          <td><?= htmlspecialchars($data['jenis']) ?></td> <!-- Field tetap 'jenis' -->
          <td><?= htmlspecialchars($data['merek']) ?></td>
          <td><?= htmlspecialchars($data['ukuran_inch']) ?> inch</td>
          <td><?= nl2br(htmlspecialchars($data['spesifikasi'])) ?></td>
          <td><?= htmlspecialchars($data['status']) ?></td>
          <td><?= (int)$data['jumlah_pemakaian'] ?></td>
          <td>
            <a href="alat.php?kategori=monitor&edit=<?= urlencode($data['id_alat']) ?>" class="btn-edit">
              <i class="ri-edit-line"></i>
            </a>
            <a href="alat.php?kategori=monitor&hapus=<?= urlencode($data['id_alat']) ?>" class="btn-hapus"
              onclick="return confirm('Yakin ingin menghapus alat ini?')">
              <i class="ri-delete-bin-line"></i>
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php else: ?>
  <p class="text-muted">Tidak ada data monitor yang tersedia.</p>
<?php endif; ?>
