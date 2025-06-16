function setActive(button) {
  // Hapus kelas active dari semua tombol
  document.querySelectorAll(".menu-btn").forEach(btn => btn.classList.remove("active"));

  // Tambahkan ke tombol yang diklik
  button.classList.add("active");
}
