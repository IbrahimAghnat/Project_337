
<?php
include '../config/db.php';

$message = "";
$type = "";

if (isset($_POST['daftar'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // cek apakah username sudah dipakai
    $cek = $conn->query("SELECT * FROM tb_users WHERE username='$username'");
    if ($cek->num_rows > 0) {
        $message = "Username sudah digunakan!";
        $type = "error";
    } else {
        $sql = "INSERT INTO tb_users (username, password, role) VALUES ('$username','$password','$role')";
        if ($conn->query($sql)) {
            $message = "Akun berhasil dibuat!";
            $type = "success";
        } else {
            $message = "Terjadi kesalahan: " . $conn->error;
            $type = "error";
        }
    }
}

if (isset($_POST['kembali'])) {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="css/register.css" rel="stylesheet">
  <style>
    /* Popup styling */
    .popup {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 16px 24px;
      border-radius: 12px;
      color: #fff;
      font-size: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      opacity: 0;
      transform: translateY(-20px);
      transition: all 0.4s ease;
      z-index: 9999;
    }
    .popup.show {
      opacity: 1;
      transform: translateY(0);
    }
    .popup.success { background: #28a745; }  /* hijau */
    .popup.error { background: #dc3545; }    /* merah */
  </style>
</head>
<body>
  <?php if ($message != ""): ?>
    <div id="popup" class="popup <?php echo $type; ?>"><?php echo $message; ?></div>
    <script>
      const popup = document.getElementById("popup");
      popup.classList.add("show");

      setTimeout(() => {
        popup.classList.remove("show");
        <?php if ($type == "success"): ?>
          // redirect hanya jika sukses
          window.location.href = "home.php";
        <?php endif; ?>
      }, 3000); // 3 detik
    </script>
  <?php endif; ?>

  <div class="register-frame">
    <h2 class="register-title">Register</h2>

    <form method="post" class="register-form">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" required>
      </div>

      <div class="form-group password-wrap">
        <label>Password</label>
        <input type="password" name="password" id="password" required>
        <img id="togglePassword" class="toggle-eye" 
             src="../assets/eye-hide.png" alt="Toggle Password">
      </div>

      <div class="form-group">
        <label>Role</label>
        <select name="role" required>
          <option value="staff">Staff</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <button type="submit" name="daftar" class="btn-primary">Daftar</button>
    </form>

    <form method="post" style="margin-top:15px;">
      <button type="submit" name="kembali" class="btn-secondary">Kembali</button>
    </form>
  </div>

  <script>
    const toggle = document.getElementById("togglePassword");
    const pwd = document.getElementById("password");

    toggle.addEventListener("click", () => {
      if (pwd.type === "password") {
        pwd.type = "text";
        toggle.src = "../assets/eye-show.png"; 
      } else {
        pwd.type = "password";
        toggle.src = "../assets/eye-hide.png"; 
      }
    });
  </script>
</body>
</html>

