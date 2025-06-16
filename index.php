<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home - Inventaris PT Alamanda</title>

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      overflow-x: hidden;
      background-color: #f8f9fa;
    }

    #sidebar {
      width: 250px;
      height: 100vh;
      background-color: #e2e2e2;
      position: fixed;
      top: 0;
      left: 0;
      padding: 1.5rem 1rem;
      transition: all 0.3s;
      z-index: 1000;
    }

    #sidebar.hide {
      left: -260px;
    }

    #sidebar .logo {
      text-align: center;
      margin-bottom: 2rem;
    }

    #sidebar .logo img {
      max-width: 150px;
      height: auto;
    }

    .nav-btn {
      display: block;
      width: 100%;
      margin: 0.5rem 0;
      padding: 0.75rem;
      background-color: #fff;
      color: #0083ba;
      border: none;
      border-radius: 8px;
      text-align: left;
      font-weight: 700;
      text-decoration: none;
      transition: all 0.2s ease-in-out;
    }

    .nav-btn:hover {
      background-color: #d0f0fb;
      color: #0070a0;
    }

    #hamburger {
      position: fixed;
      top: 1rem;
      left: 1rem;
      z-index: 1100;
      background: #fff;
      border: none;
      padding: 0.3rem 0.5rem;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    #hamburger i {
      font-size: 1.2rem;
    }

    /* Navbar */
    .navbar-custom {
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      height: 60px;
      background-color: #ffffff;
      border-bottom: 1px solid #dee2e6;
      z-index: 998;
      transition: left 0.3s;
    }

    .navbar-custom.shifted {
      left: 0;
    }

    /* Content */
    #content {
      margin-left: 250px;
      padding-top: 80px;
      transition: margin-left 0.3s;
    }

    #sidebar.hide + .navbar-custom {
      left: 0;
    }

    #sidebar.hide + .navbar-custom + #content {
      margin-left: 0;
    }

    .form-control {
      border-radius: 0.5rem;
    }

    .btn {
      border-radius: 0.5rem;
    }

    @media (max-width: 768px) {
      #sidebar {
        left: -260px;
      }

      #content,
      .navbar-custom {
        margin-left: 0 !important;
        left: 0 !important;
      }

      #hamburger {
        left: 1rem !important;
      }
    }
  </style>
</head>
<body>

  <!-- Hamburger Button -->
  <button id="hamburger"><i class="bi bi-list"></i></button>

  <!-- Sidebar -->
  <div id="sidebar">
    <div class="logo">
      <img src="assets/img/logo-alamanda.png" alt="Logo Alamanda" />
    </div>
    <a href="index.php" class="nav-btn"><i class="bi bi-house-door-fill me-2"></i> Home</a>
    <a href="alat_user.php" class="nav-btn"><i class="bi bi-tools me-2"></i> Alat</a>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light navbar-custom px-4">
    <div class="container-fluid">
    <a class="navbar-brand fw-bold text-primary ms-4" href="index.php">Home</a>
      <div class="ms-auto d-flex align-items-center">
        <form class="d-flex me-3" role="search">
          <input class="form-control me-2" type="search" placeholder="Cari sesuatu..." aria-label="Search">
          <button class="btn btn-outline-primary" type="submit">Cari</button>
        </form>
        <a href="login.php" class="btn btn-success">
          <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div id="content">
    <section class="welcome-section p-4">
      <h2 class="text-success fw-bold text-center">SELAMAT DATANG</h2>
      <p class="fs-5 text-center">DI INVENTARIS BARANG PT ALAMANDA REKA CIPTA</p>
      <p class="fst-italic text-muted text-center">
        “Kelola data inventaris Anda dengan mudah, cepat, dan efisien. Akses informasi barang kapan saja dan di mana saja.”
      </p>

      <div class="row justify-content-center mt-4 g-4">
        <div class="col-md-5">
          <img src="assets/img/Rectangle 14.png" alt="Rak Barang" class="img-fluid rounded-3 shadow-sm" />
        </div>
        <div class="col-md-5">
          <img src="assets/img/Rectangle 15.png" alt="Scanner" class="img-fluid rounded-3 shadow-sm" />
        </div>
      </div>
    </section>
  </div>

  <!-- JavaScript -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.getElementById('hamburger');
    const navbar = document.querySelector('.navbar-custom');
    const content = document.getElementById('content');

    hamburger.addEventListener('click', () => {
      sidebar.classList.toggle('hide');
      navbar.classList.toggle('shifted');
      content.classList.toggle('full-width');
    });
  </script>

</body>
</html>
