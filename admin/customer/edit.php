<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include("../../config/db.php");
include("../../layout/header.php");
include("../../layout/sidebar.php");

$customer_id = intval($_GET['id'] ?? 0);

// Buscar dados do cliente
$query = "
  SELECT customers.*, a.neighborhood, a.cep, a.necessity
  FROM customers
  LEFT JOIN addresses a ON a.customer_id = customers.id
  WHERE customers.id = ? AND customers.created_by = ?
  LIMIT 1
";



$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $customer_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
    die("Eleitor não encontrado.");
}

// Buscar candidatos
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, name FROM candidates WHERE created_by = ? ORDER BY name ASC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$candidates = $stmt->get_result();
?>

<div class="content-wrapper">
  <section class="content-header d-flex justify-content-between align-items-center">
    <h1>Editar Eleitor</h1>
    <a href="index.php" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Voltar
    </a>
  </section>

  <section class="content">
    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Formulário de Edição</h3>
        </div>
        <div class="card-body">
          <form action="action/update.php" method="post">

          <input type="hidden" name="id" value="<?= $customer_id ?>">

          <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($customer['name'] ?? '') ?>" required>
          </div>

          <div class="form-group">
            <label>CPF</label>
            <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($customer['cpf'] ?? '') ?>" required>
          </div>

          <div class="form-group">
            <label>Candidato</label>
            <select name="candidate_id" class="form-control" required>
              <option value="">Selecione...</option>
              <?php while ($cand = $candidates->fetch_assoc()): ?>
                <option value="<?= $cand['id'] ?>" <?= $cand['id'] == $customer['candidate_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($cand['name']) ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Bairro</label>
            <input type="text" name="neighborhood" class="form-control" value="<?= htmlspecialchars($customer['neighborhood'] ?? '') ?>" required>
          </div>

          <div class="form-group">
            <label>CEP</label>
            <input type="text" name="cep" class="form-control" value="<?= htmlspecialchars($customer['cep'] ?? '') ?>" required>
          </div>

          <div class="form-group">
            <label>Necessidade</label>
            <textarea name="necessity" class="form-control" rows="3" required><?= htmlspecialchars($customer['necessity'] ?? '') ?></textarea>
          </div>
          </div>
          <div class="card-footer">
          <button type="submit" class="btn btn-primary">Salvar Alterações</button>
          </div>
          </form>
      </div>
    </section>
</div>

<!-- Máscara para CPF e CEP -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const cpfInput = document.querySelector('input[name="cpf"]');
  const cepInput = document.querySelector('input[name="cep"]');

  if (cpfInput) {
    cpfInput.addEventListener("input", function () {
      let value = cpfInput.value.replace(/\D/g, '');
      if (value.length > 11) value = value.slice(0, 11);
      value = value.replace(/(\d{3})(\d)/, "$1.$2");
      value = value.replace(/(\d{3})(\d)/, "$1.$2");
      value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      cpfInput.value = value;
    });
  }

  if (cepInput) {
    cepInput.addEventListener("input", function () {
      let value = cepInput.value.replace(/\D/g, '');
      if (value.length > 8) value = value.slice(0, 8);
      value = value.replace(/(\d{5})(\d)/, "$1-$2");
      cepInput.value = value;
    });
  }
});
</script>

<?php include("../../layout/footer.php"); ?>
