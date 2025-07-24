<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

include("../../config/db.php");

// Recupera token do usuário logado
$user_id = $_SESSION['user_id'];
$stmt    = $conn->prepare("SELECT token FROM api_tokens WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$token  = $result->fetch_assoc()['token'] ?? '[SEU_TOKEN_AQUI]';

include("../../layout/header.php");
include("../../layout/sidebar.php");
?>

<!-- Highlight.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/github-dark.min.css">

<div class="content-wrapper">
  <section class="content-header">
    <h1>Documentação da API</h1>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-body">
        <p>Utilize os comandos abaixo para testar os endpoints da API autenticados com seu token:</p>

        <h5><strong>1. Criar Eleitor</strong></h5>
        <pre><code class="language-bash">curl --location 'http://localhost/admin/api/customer/create.php' \
--header 'Authorization: Bearer <?= $token ?>' \
--header 'Content-Type: application/json' \
--data '{
  "name": "Eleitor Teste",
  "cpf": "08920194920",
  "candidate_id": 1001,
  "neighborhood": "Centro",
  "cep": "12345-678",
  "necessity": "Precisa de transporte"
}'</code></pre>

        <h5><strong>2. Listar Candidatos</strong></h5>
        <pre><code class="language-bash">curl --location 'http://localhost/admin/api/candidates/list.php' \
--header 'Authorization: Bearer <?= $token ?>'</code></pre>

        <h5><strong>3. Listar Eleitores</strong></h5>
        <pre><code class="language-bash">curl --location 'http://localhost/admin/api/customer/list.php' \
--header 'Authorization: Bearer <?= $token ?>'</code></pre>
      </div>
    </div>
  </section>
</div>

<!-- Highlight.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
<script>hljs.highlightAll();</script>

<?php include("../../layout/footer.php"); ?>
