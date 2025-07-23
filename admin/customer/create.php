<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../../login.php");
  exit;
}

include("../../config/db.php");
include("../../layout/header.php");
include("../../layout/sidebar.php");

// Buscar candidatos
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, name FROM candidates WHERE created_by = ? ORDER BY name ASC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$candidates = $stmt->get_result();

?>

<div class="content-wrapper">
  <section class="content-header d-flex justify-content-between align-items-center">
    <h1>Novo Eleitor</h1>
    <a href="index.php" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Voltar
    </a>
  </section>

  <section class="content">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Cadastro de Novo Eleitor</h3>
      </div>
      <div class="card-body">
        <form action="action/save.php" method="post">

          <div class="form-group">
            <label>Nome do Eleitor</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>CPF</label>
            <input type="text" name="cpf" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Candidato</label>
            <select name="candidate_id" class="form-control" required>
              <option value="">Selecione...</option>
              <?php while ($cand = $candidates->fetch_assoc()): ?>
                <option value="<?= $cand['id'] ?>"><?= ($cand['name']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Bairro</label>
            <input type="text" name="neighborhood" class="form-control" required>
          </div>

          <div class="form-group">
            <label>CEP</label>
            <input type="text" name="cep" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Necessidade</label>
            <textarea name="necessity" class="form-control" rows="3" required></textarea>
          </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
      </form>

    </div>
  </section>

</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const cpfInput = document.querySelector('input[name="cpf"]');
    const cepInput = document.querySelector('input[name="cep"]');

    if (cpfInput) {
      cpfInput.addEventListener("input", function() {
        let value = cpfInput.value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        cpfInput.value = value;
      });
    }

    if (cepInput) {
      cepInput.addEventListener("input", function() {
        let value = cepInput.value.replace(/\D/g, '');
        if (value.length > 8) value = value.slice(0, 8);
        value = value.replace(/(\d{5})(\d)/, "$1-$2");
        cepInput.value = value;
      });
    }
  });
</script>

<?php include("../../layout/footer.php"); ?>