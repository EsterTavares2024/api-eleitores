<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

include("../../config/db.php");
include("../../layout/header.php");
include("../../layout/sidebar.php");

$userId = $_SESSION['user_id'];

// Verifica se o token já existe
$stmt = $conn->prepare("SELECT token FROM api_tokens WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$token = $result->fetch_assoc()['token'] ?? null;
$stmt->close();
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Token de Acesso à API</h1>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-body">
        <?php if ($token): ?>
          <label>Seu token:</label>
          <input type="text" readonly class="form-control mb-3" value="<?= htmlspecialchars($token) ?>">
          <button class="btn btn-warning" onclick="renovarToken()">Renovar Token</button>
        <?php else: ?>
          <p>Você ainda não possui um token de acesso à API.</p>
          <button class="btn btn-primary" onclick="gerarToken()">Gerar Token</button>
        <?php endif; ?>

        <small class="d-block mt-3 text-muted">
          Use este token como <code>Authorization: Bearer [TOKEN]</code> ao fazer chamadas para a API.
        </small>

        <small class="d-block mt-3 text-muted">
        <a href="/admin/docs-api/docs.php">→ Acessar documentação da API</a>
        </small>

        
      </div>
    </div>
  </section>
</div>

<script>
  function gerarToken() {
    fetch('action/generate_token.php', { method: 'POST' })
      .then(res => res.json())
      .then(data => location.reload())
      .catch(err => alert("Erro ao gerar token."));
  }

  function renovarToken() {
    gerarToken();
  }
</script>

<?php include("../../layout/footer.php"); ?>
