<?php
require('fpdf/fpdf.php');
include 'koneksi.php';

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

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Peminjaman Alat', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
if ($tgl_dari && $tgl_sampai) {
  $pdf->Cell(0, 6, "Periode: $tgl_dari s.d. $tgl_sampai", 0, 1);
}
if ($kategori) {
  $pdf->Cell(0, 6, "Kategori: $kategori", 0, 1);
}
$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 8, 'No', 1);
$pdf->Cell(30, 8, 'ID Pinjam', 1);
$pdf->Cell(50, 8, 'Peminjam', 1);
$pdf->Cell(60, 8, 'Alat', 1);
$pdf->Cell(30, 8, 'Kategori', 1);
$pdf->Cell(30, 8, 'Tgl Pinjam', 1);
$pdf->Cell(30, 8, 'Tgl Kembali', 1);
$pdf->Cell(25, 8, 'Status', 1);
$pdf->Ln();

$no = 1;
$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_assoc($result)) {
  $alat = $row['merek'] . ' ' . $row['jenis'];
  $tgl_kembali = $row['tanggal_kembali'] ?: '-';

  $pdf->Cell(10, 8, $no++, 1);
  $pdf->Cell(30, 8, $row['id_peminjaman'], 1);
  $pdf->Cell(50, 8, $row['peminjam'], 1);
  $pdf->Cell(60, 8, $alat, 1);
  $pdf->Cell(30, 8, $row['kategori'], 1);
  $pdf->Cell(30, 8, $row['tanggal_pinjam'], 1);
  $pdf->Cell(30, 8, $tgl_kembali, 1);
  $pdf->Cell(25, 8, $row['status'], 1);
  $pdf->Ln();
}

$pdf->Output();
