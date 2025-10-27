<?php
include 'config/db.php';
session_start();

if (isset($_SESSION["is_login"])) {
  header("location: auth/home.php");
}

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM tb_users WHERE username='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['role'] = $row['role'];
      $_SESSION["is_login"] = true;
      header("Location: auth/home.php");
      exit;
    } else {
      $error = "Password salah!";
    }
  } else {
    $error = "User tidak ditemukan!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="login.css" rel="stylesheet">
</head>

<body>
  <!-- Logo pojok kiri atas -->
  <div class="logo">
    <img src="assets/logo.png" alt="Logo">
  </div>

  <div class="c_login-frame1">
    <div class="c_login-text7">
      <p class="c_login-text8">Login</p>
    </div>

    <form method="post" class="login-form">
      <div class="input-group">
        <label>USERNAME</label>
        <input type="text" name="username" required>
      </div>

      <div class="input-group password-group">
        <label>PASSWORD</label>
        <input type="password" name="password" id="password" required>
        <img id="togglePassword" class="toggle-eye" src="assets/eye-hide.png" alt="Toggle Password">
      </div>

      <button type="submit" name="login" class="c_login-component">Login</button>

      <?php if (!empty($error)): ?>
        <p class="error-msg"><?= $error ?></p>
      <?php endif; ?>
    </form>
  </div>

  <script>
    const toggle = document.getElementById("togglePassword");
    const pwd = document.getElementById("password");

    toggle.addEventListener("click", () => {
      if (pwd.type === "password") {
        pwd.type = "text";
        toggle.src = "assets/eye-show.png"; // ganti ke icon "show"
      } else {
        pwd.type = "password";
        toggle.src = "assets/eye-hide.png"; // ganti ke icon "hide"
      }
    });

    // Button click effect
    const btn = document.querySelector(".c_login-component");
    btn.addEventListener("mousedown", () => {
      btn.classList.add("pressed");
    });
    btn.addEventListener("mouseup", () => {
      btn.classList.remove("pressed");
    });
  </script>
</body>

</html>