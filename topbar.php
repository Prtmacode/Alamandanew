<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<header class="topbar">
  <h1><?= htmlspecialchars($page_title ??'dashboard')?>
  </h1>

  <div class="topbar-right">
    <div class="user-menu">
      <button class="user-btn" onclick="toggleDropdown()">
        <i class="ri-user-3-line"></i> <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?> <i class="ri-arrow-down-s-line"></i>
      </button>
      <div class="dropdown" id="userDropdown">
        <a href="#">Profil</a>
        <a href="index.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
      </div>
      <div class="hamburger" id="hamburger">
  <span></span>
  <span></span>
  <span></span>
</div>

    </div>
  </div>
</header>

<style>
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 25px;
  background-color: #ffffff;
  border-bottom: 1px solid #e0e0e0;
}

.user-menu {
  position: relative;
  display: inline-block;
}

.user-btn {
  background: none;
  border: none;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
}

.dropdown {
  display: none;
  position: absolute;
  right: 0;
  top: 100%;
  margin-top: 10px;
  background-color: white;
  border: 1px solid #ddd;
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
  border-radius: 4px;
  overflow: hidden;
  z-index: 100;
}

.dropdown a {
  display: block;
  padding: 10px 15px;
  text-decoration: none;
  color: #333;
  transition: background 0.2s;
}

.dropdown a:hover {
  background-color: #f5f5f5;
}

.user-menu.active .dropdown {
  display: block;
}
</style>

<script>
function toggleDropdown() {
  const menu = document.querySelector('.user-menu');
  menu.classList.toggle('active');
}

window.addEventListener('click', function(e) {
  const menu = document.querySelector('.user-menu');
  if (!menu.contains(e.target)) {
    menu.classList.remove('active');
  }
});
</script>
