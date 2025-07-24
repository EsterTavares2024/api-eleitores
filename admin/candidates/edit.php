<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

include("../../config/db.php");
include("../../layout/header.php");
include("../../layout/sidebar.php");

// Verifica o ID
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: index.php?error=1");
    exit;
}

// Busca os dados do candidato
$stmt = $conn->prepare("SELECT * FROM candidates WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result    = $stmt->get_result();
$candidate = $result->fetch_assoc();

if (!$candidate) {
    header("Location: index.php?error=1");
    exit;
}
?>

<div class="content-wrapper">
  <section class="content-header d-flex justify-content-between align-items-center">
      <h1>Editar Candidato</h1>
        <a href="index.php" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Voltar
    </a>
  </section>

  <section class="content">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Dados do Candidato</h3>
      </div>

      <form action="action/update.php" method="post">
        <input type="hidden" name="id" value="<?= $candidate['id'] ?>">

        <div class="card-body">
          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($candidate['name']) ?>" required>
          </div>

          <div class="form-group">
            <label>Partido</label>
            <input type="text" name="party" class="form-control" value="<?= htmlspecialchars($candidate['party']) ?>">
          </div>

          <div class="form-group">
            <label>Descrição</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($candidate['description']) ?></textarea>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Salvar Alterações</button>
          <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>
    </div>
  </section>
</div>

<?php include("../../layout/footer.php"); ?>
