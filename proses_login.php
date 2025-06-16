<?php
session_start();

// Simulasi user (bisa diganti dengan query ke database)
$valid_username = "admin";
$valid_password = "admin123"; // password minimal 8 karakter

// Ambil data dari form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi sederhana
if ($username === $valid_username && $password === $valid_password) {
    // Simpan sesi login
    $_SESSION['username'] = $username;
    
    // Redirect ke dashboard
    header("Location: dashboard.php");
    exit();
} else {
    // Jika gagal login
    echo "<script>
        alert('Username atau password salah!');
        window.location.href = 'login.php';
    </script>";
}
?>
