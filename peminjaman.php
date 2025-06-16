<?php
include 'koneksi.php';

$kategori = $_GET['kategori'] ?? 'scanner';

if (isset($_POST['simpan'])) {
  $id_peminjaman = 'PMJ' . time();
  $id_alat = $_POST['id_alat'];
  $peminjam = $_POST['nama'];
  $divisi = $_POST['divisi'] ?? null;
  $tgl_pinjam = $_POST['tgl_pinjam'];
  $tgl_kembali = $_POST['tgl_kembali'];
  $keterangan = $_POST['keterangan'];

  // Cek apakah alat sedang dipinjam
  $cekStatus = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT status FROM alat WHERE id_alat='$id_alat'"));
  if ($cekStatus['status'] === 'Dipinjam') {
    echo "<script>alert('Alat ini sedang dipinjam!'); window.history.back();</script>";
    exit();
  }

  $query = "INSERT INTO peminjaman 
    (id_peminjaman, id_alat, peminjam, divisi, tanggal_pinjam, tanggal_kembali, status, keterangan) 
    VALUES 
    ('$id_peminjaman', '$id_alat', '$peminjam', '$divisi', '$tgl_pinjam', '$tgl_kembali', 'Dipinjam', '$keterangan')";

  if (mysqli_query($koneksi, $query)) {
    // Ubah status alat jadi Dipinjam
    mysqli_query($koneksi, "UPDATE alat SET status='Dipinjam' WHERE id_alat='$id_alat'");

    header("Location: peminjaman.php?kategori=$kategori&success=1");
    exit();
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Peminjaman Alat</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
<div class="container">
<?php $page_title = "Peminjaman"; ?>
  <?php include 'sidebar.php'; ?>
  <main class="main">
    <?php include 'topbar.php'; ?>

    <div class="tabs-peminjaman" style="margin-bottom: 20px;">
      <a href="peminjaman.php?kategori=scanner" class="tab <?= $kategori === 'scanner' ? 'active' : '' ?>">Scanner</a>
      <a href="peminjaman.php?kategori=monitor" class="tab <?= $kategori === 'monitor' ? 'active' : '' ?>">Monitor</a>
      <a href="peminjaman.php?kategori=cpu" class="tab <?= $kategori === 'cpu' ? 'active' : '' ?>">CPU</a>
    </div>

    <form class="form-peminjaman" method="POST" style="display: flex; gap: 40px;">
      <div class="form-left" style="flex: 1;">
        <label>ID Alat</label>
        <select name="id_alat" required>
          <option value="">-- Pilih Alat --</option>
          <?php
          $alat = mysqli_query($koneksi, "SELECT * FROM alat WHERE kategori='$kategori'");
          while ($row = mysqli_fetch_assoc($alat)) {
            echo "<option value='{$row['id_alat']}'>{$row['id_alat']} - {$row['jenis']} ({$row['merek']})</option>";
          }
          ?>
        </select>

        <label>Nama Peminjam</label>
        <input type="text" name="nama" placeholder="cth: Andi Saputra" required>

        <label>Divisi</label>
        <input type="text" name="divisi" placeholder="cth: Teknisi / Admin">

        <label>Deskripsi / Keterangan</label>
        <textarea name="keterangan" placeholder="Keterangan tambahan jika ada..." rows="4"></textarea>
      </div>

      <div class="form-right" style="flex: 1;">
        <label>Tanggal Pinjam</label>
        <div class="tanggal-input" style="display: flex; align-items: center; gap: 10px;">
          <i class="ri-calendar-line"></i>
          <input type="date" name="tgl_pinjam" required>
        </div>

        <label style="margin-top: 20px;">Tanggal Kembali</label>
        <div class="tanggal-input" style="display: flex; align-items: center; gap: 10px;">
          <i class="ri-calendar-line"></i>
          <input type="date" name="tgl_kembali" required>
        </div>

        <div class="modal-actions" style="margin-top: 40px; display: flex; justify-content: flex-end; gap: 10px;">
          <button type="submit" name="simpan" class="btn-simpan"><i class="ri-save-line"></i> Simpan</button>
          <a href="peminjaman.php" class="btn-batal">Batal</a>
        </div>
      </div>
    </form>
  </main>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    if (params.get('success')) alert("Peminjaman berhasil disimpan!");
  });
</script>
</body>
</html>
