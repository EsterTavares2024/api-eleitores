<?php
session_start();
include("config/db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);

    if ($stmt->fetch()) {
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $userId;
            header("Location: admin/dashboard/index.php");
            exit;
        } else {
            $error = "Senha incorreta.";
        }
    } else {
        $error = "Usuário não encontrado.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="assets\AdminLTE\dist\css\adminlte.min.css">
  <link rel="stylesheet" href="assets\AdminLTE\plugins\fontawesome-free\css\all.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"><b>Admin</b>Login</div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Faça login para continuar</p>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Usuário" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Senha" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
