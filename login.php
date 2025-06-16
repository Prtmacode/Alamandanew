<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
  <div class="login-container">
    <div class="login-form">
      <h2>Login</h2>
      <form action="proses_login.php" method="post">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>

        <label for="password">Password*</label>
        <input type="password" id="password" name="password" placeholder="minimum 8 characters" required>

        <div class="login-options">
          <label><input type="checkbox"> Remember me</label>
          <a href="#">Forgot password?</a>
        </div>

        <button type="submit" class="login-button">Login</button>
      </form>
    </div>
    <div class="login-image">
      <img src="assets/img/gambarlogin.png">
    </div>
  </div>
</body>
</html>
