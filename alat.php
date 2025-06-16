<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

$kategori = $_GET['kategori'] ?? '';
$edit_mode = false;
$edit_data = [];

// Hapus data
if (isset($_GET['hapus'])) {
  $hapus_id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM alat WHERE id_alat='$hapus_id'");
  header("Location: alat.php?kategori=$kategori&deleted=1");
  exit();
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
  $edit_id = $_GET['edit'];
  $edit_mode = true;
  $result = mysqli_query($koneksi, "SELECT * FROM alat WHERE id_alat='$edit_id'");
  $edit_data = mysqli_fetch_assoc($result);
}

// Simpan data
if (isset($_POST['simpan'])) {
  $kategori = $_POST['kategori'];
  $id_alat  = $_POST['id_alat'];
  $jenis    = $_POST['jenis'] ?? '';
  $seri     = $_POST['seri'] ?? '';
  $merek    = $_POST['merek'];
  $ukuran   = isset($_POST['ukuran']) ? strtolower($_POST['ukuran']) : null;
  $spesifikasi = $_POST['spesifikasi'] ?? null;
  $ukuran_inch = $_POST['ukuran_inch'] !== '' ? $_POST['ukuran_inch'] : null;
  $status   = $_POST['status'];
  $tgl_masuk = date('Y-m-d');

  // Validasi kolom yang wajib diisi
  if ($kategori === 'cpu' && trim($jenis) === '') {
    die("Error: Kolom 'Jenis' tidak boleh kosong untuk kategori CPU.");
  }

  if (($kategori === 'monitor' || $kategori === 'scanner') && trim($seri) === '') {
    die("Error: Kolom 'Seri' tidak boleh kosong untuk kategori $kategori.");
  }

  if (isset($_POST['edit_mode']) && $_POST['edit_mode'] === '1') {
    $query = "UPDATE alat SET 
                kategori='$kategori', 
                jenis=" . ($jenis !== '' ? "'$jenis'" : "NULL") . ",
                seri=" . ($seri !== '' ? "'$seri'" : "NULL") . ",
                merek='$merek', 
                ukuran=" . ($ukuran ? "'$ukuran'" : "NULL") . ", 
                spesifikasi=" . ($spesifikasi ? "'$spesifikasi'" : "NULL") . ", 
                ukuran_inch=" . ($ukuran_inch ? "'$ukuran_inch'" : "NULL") . ", 
                status='$status'
              WHERE id_alat='$id_alat'";
    if (mysqli_query($koneksi, $query)) {
      header("Location: alat.php?kategori=$kategori&updated=1");
      exit();
    }
  } else {
    $query = "INSERT INTO alat 
      (kategori, id_alat, jenis, seri, merek, ukuran, spesifikasi, ukuran_inch, status, resolusi, lokasi, keterangan, tgl_masuk) 
      VALUES 
      ('$kategori', '$id_alat', " . 
      ($jenis !== '' ? "'$jenis'" : "NULL") . ", " . 
      ($seri !== '' ? "'$seri'" : "NULL") . ", '$merek', " . 
      ($ukuran ? "'$ukuran'" : "NULL") . ", " . 
      ($spesifikasi ? "'$spesifikasi'" : "NULL") . ", " . 
      ($ukuran_inch ? "'$ukuran_inch'" : "NULL") . ", 
      '$status', NULL, NULL, NULL, '$tgl_masuk')";

    if (mysqli_query($koneksi, $query)) {
      header("Location: alat.php?kategori=$kategori&success=1");
      exit();
    }
  }

  echo "Error: " . mysqli_error($koneksi);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Alat</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    .modal-overlay {
      display: none;
      position: fixed;
      z-index: 9999;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-overlay.show {
      display: flex;
    }
    .modal-content {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      width: 500px;
      max-width: 90%;
      max-height: 90%;
      overflow-y: auto;
    }
    .close-modal {
      cursor: pointer;
      font-size: 24px;
      float: right;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php $page_title = "Alat"; ?>
    <?php include 'sidebar.php'; ?>
    <main class="main">
      <?php include 'topbar.php'; ?>

      <div class="content-header">
        <button class="btn-tambah" onclick="openModal()"><i class="ri-add-line"></i> Tambah Alat</button>
      </div>

      <div class="tabs">
        <a href="alat.php" class="tab-button <?= ($kategori === '') ? 'active' : '' ?>">Semua</a>
        <a href="alat.php?kategori=scanner" class="tab-button <?= ($kategori === 'scanner') ? 'active' : '' ?>">Scanner</a>
        <a href="alat.php?kategori=cpu" class="tab-button <?= ($kategori === 'cpu') ? 'active' : '' ?>">CPU</a>
        <a href="alat.php?kategori=monitor" class="tab-button <?= ($kategori === 'monitor') ? 'active' : '' ?>">Monitor</a>
      </div>

      <div class="table-container">
        <?php
          if ($kategori === 'scanner') {
            include 'tabel_scanner.php';
          } elseif ($kategori === 'cpu') {
            include 'tabel_cpu.php';
          } elseif ($kategori === 'monitor') {
            include 'tabel_monitor.php';
          } else {
            include 'table_alatadmin.php';
          }
        ?>
      </div>
    </main>
  </div>

  <!-- Modal -->
  <div class="modal-overlay" id="formModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3><?= $edit_mode ? 'Edit Alat' : 'Tambah Alat' ?></h3>
        <span class="close-modal" onclick="closeModal()">&times;</span>
      </div>
      <form method="POST" class="form-alat">
        <input type="hidden" name="edit_mode" value="<?= $edit_mode ? '1' : '0' ?>">

        <label>Kategori Alat</label>
        <select name="kategori" id="kategori" required onchange="handleKategoriChange()">
          <option value="">-- Pilih Kategori --</option>
          <option value="scanner" <?= $kategori === 'scanner' ? 'selected' : '' ?>>Scanner</option>
          <option value="cpu" <?= $kategori === 'cpu' ? 'selected' : '' ?>>CPU</option>
          <option value="monitor" <?= $kategori === 'monitor' ? 'selected' : '' ?>>Monitor</option>
        </select>

        <label>ID Alat</label>
        <input type="text" name="id_alat" required value="<?= $edit_data['id_alat'] ?? '' ?>" <?= $edit_mode ? 'readonly' : '' ?>>

        <label id="label-jenis">Jenis</label>
        <input type="text" name="jenis" id="input-jenis" value="<?= $edit_data['jenis'] ?? '' ?>">

        <label id="label-seri">Seri</label>
        <input type="text" name="seri" id="input-seri" value="<?= $edit_data['seri'] ?? '' ?>">

        <label>Merek</label>
        <input type="text" name="merek" required value="<?= $edit_data['merek'] ?? '' ?>">

        <div id="field-ukuran" class="form-group">
          <label>Ukuran (khusus Scanner)</label>
          <select name="ukuran">
            <option value="">-- Pilih Ukuran --</option>
            <option value="kecil" <?= (isset($edit_data['ukuran']) && $edit_data['ukuran'] === 'kecil') ? 'selected' : '' ?>>Kecil</option>
            <option value="sedang" <?= (isset($edit_data['ukuran']) && $edit_data['ukuran'] === 'sedang') ? 'selected' : '' ?>>Sedang</option>
            <option value="besar" <?= (isset($edit_data['ukuran']) && $edit_data['ukuran'] === 'besar') ? 'selected' : '' ?>>Besar</option>
          </select>
        </div>

        <div id="field-spesifikasi" class="form-group">
          <label>Spesifikasi</label>
          <textarea name="spesifikasi" rows="3"><?= $edit_data['spesifikasi'] ?? '' ?></textarea>
        </div>

        <div id="field-inch" class="form-group">
          <label>Ukuran Inci (Monitor)</label>
          <input type="text" name="ukuran_inch" value="<?= $edit_data['ukuran_inch'] ?? '' ?>">
        </div>

        <label>Status</label>
        <select name="status" required>
          <?php
          $status_opsi = ['Tersedia', 'Rusak', 'Dalam Perbaikan', 'Hilang'];
          foreach ($status_opsi as $s) {
            $sel = (isset($edit_data['status']) && $edit_data['status'] === $s) ? 'selected' : '';
            echo "<option value='$s' $sel>$s</option>";
          }
          ?>
        </select>

        <div class="modal-actions">
          <button type="submit" name="simpan" class="btn-simpan">
            <i class="ri-save-line"></i> <?= $edit_mode ? 'Update' : 'Simpan' ?>
          </button>
          <?php if ($edit_mode): ?>
            <a href="alat.php?kategori=<?= $kategori ?>" class="btn-batal">Batal</a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openModal() {
      document.getElementById('formModal').classList.add('show');
    }

    function closeModal() {
      document.getElementById('formModal').classList.remove('show');
    }

    function handleKategoriChange() {
      const kategori = document.getElementById('kategori').value;

      const jenis = document.getElementById('input-jenis');
      const labelJenis = document.getElementById('label-jenis');
      const seri = document.getElementById('input-seri');
      const labelSeri = document.getElementById('label-seri');

      jenis.style.display = labelJenis.style.display = 'none';
      seri.style.display = labelSeri.style.display = 'none';
      jenis.required = seri.required = false;

      if (kategori === 'cpu') {
        jenis.style.display = labelJenis.style.display = 'block';
        jenis.required = true;
      } else if (kategori === 'scanner' || kategori === 'monitor') {
        seri.style.display = labelSeri.style.display = 'block';
        seri.required = true;
      }

      document.getElementById('field-ukuran').style.display = kategori === 'scanner' ? 'block' : 'none';
      document.getElementById('field-spesifikasi').style.display = (kategori === 'cpu' || kategori === 'monitor') ? 'block' : 'none';
      document.getElementById('field-inch').style.display = kategori === 'monitor' ? 'block' : 'none';
    }

    document.addEventListener("DOMContentLoaded", function () {
      const params = new URLSearchParams(window.location.search);
      if (params.get('success')) alert("Data berhasil ditambahkan!");
      if (params.get('updated')) alert("Data berhasil diperbarui!");
      if (params.get('deleted')) alert("Data berhasil dihapus!");
      handleKategoriChange();
      <?php if ($edit_mode): ?> openModal(); <?php endif; ?>
    });
  </script>
</body>
</html>
