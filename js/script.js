function toggleDropdown() {
  const menu = document.querySelector(".user-menu");
  menu.classList.toggle("active");
}

// Tutup dropdown jika klik di luar area
window.addEventListener("click", function (e) {
  const menu = document.querySelector(".user-menu");
  if (!menu.contains(e.target)) {
    menu.classList.remove("active");
  }
});

// Alat js
document.addEventListener("DOMContentLoaded", function () {
  const tabButtons = document.querySelectorAll(".tab-button");
  const tabContents = document.querySelectorAll(".tab-content");

  tabButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const targetId = button.getAttribute("data-target");

      // Nonaktifkan semua tab
      tabButtons.forEach((btn) => btn.classList.remove("active"));
      tabContents.forEach((content) => content.classList.remove("active"));

      // Aktifkan tab yang diklik
      button.classList.add("active");
      document.getElementById(targetId).classList.add("active");
    });
  });
});
