<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$userId = $_SESSION['user_id'];
include("../../config/db.php");

// Verificação e salvamento
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $party = trim($_POST['party']);
    $description = trim($_POST['description']);

    // Verifica se o nome está vazio
    if (!$name) {
        header("Location: create.php?error=empty");
        exit;
    }

    // Verifica duplicidade por usuário
    $check = $conn->prepare("SELECT id FROM candidates WHERE name = ? AND created_by = ?");
    $check->bind_param("si", $name, $userId);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();
        header("Location: create.php?error=duplicate");
        exit;
    }
    $check->close();

    // Insere novo candidato
    $stmt = $conn->prepare("INSERT INTO candidates (name, party, description, created_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $party, $description, $userId);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php?success=1");
    exit;
}

// Se não for POST, mostra o formulário
include("../../layout/header.php");
include("../../layout/sidebar.php");
?>

<div class="content-wrapper">
  <section class="content-header d-flex justify-content-between align-items-center">
    <h1>Novo Candidato</h1>
      <a href="index.php" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Voltar
      </a>
  </section>

  <section class="content">
    <div class="card card-primary">
      <div class="card-header">
      <h3 class="card-title">Cadastro de Novo Candidato</h3>
    </div>
    <div class="card-body">
      <form method="post">
      <div class="form-group">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Partido</label>
        <input type="text" name="party" class="form-control">
      </div>
      <div class="form-group">
        <label>Descrição</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
      </div>
      </div>
      <div class="card-footer">
      <button type="submit" class="btn btn-success">Salvar</button>
      </div>
      </form>
  </div>
</section>

</div>

<?php include("../../layout/footer.php"); ?>