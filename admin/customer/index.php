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

// Controle de limite (quantos por página)
$limitOptions = [10, 25, 50, 100];
$defaultLimit = 10;

$limit = isset($_GET['limit']) && in_array(intval($_GET['limit']), $limitOptions)
  ? intval($_GET['limit'])
  : $defaultLimit;

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Total de registros
$countQuery = $conn->prepare("SELECT COUNT(*) FROM customers WHERE created_by = ?");
$countQuery->bind_param("i", $userId);
$countQuery->execute();
$countQuery->bind_result($total);
$countQuery->fetch();
$countQuery->close();

$totalPages = ceil($total / $limit);

// Buscar eleitores com limite e offset
$query = "
    SELECT customers.id, customers.name, customers.cpf, c.name AS candidate_name,
           a.neighborhood, a.cep, a.necessity
    FROM customers
    LEFT JOIN candidates c ON c.id = customers.candidate_id
    LEFT JOIN addresses a ON a.customer_id = customers.id
    WHERE customers.created_by = ?
    ORDER BY customers.created_at DESC
    LIMIT ? OFFSET ?
";

function formatCPF($cpf) {
  $cpf = preg_replace('/[^0-9]/', '', $cpf);
  return vsprintf('%s.%s.%s-%s', str_split($cpf, 3) + [9 => substr($cpf, 9, 2)]);
}
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $userId, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="d-flex justify-content-between align-items-center">
      
      <!-- Esquerda: Título -->
      <h1 class="mb-0">Meus Eleitores</h1>

      <!-- Direita: Exportar e Novo -->
      <div class="d-flex align-items-center flex-wrap gap-2">

        <form action="action/export_by_candidate.php" method="get" class="d-inline-block mr-2">
          <div class="input-group input-group-sm">
            <select name="candidate_id" class="form-control" required>
              <option value="">Exportar por Candidato</option>
              <?php
              $userId = $_SESSION['user_id'];
              $stmt = $conn->prepare("SELECT id, name FROM candidates WHERE created_by = ? ORDER BY name ASC");
              $stmt->bind_param("i", $userId);
              $stmt->execute();
              $cands = $stmt->get_result();
              while ($c = $cands->fetch_assoc()):
              
              ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
              <?php endwhile; ?>
            </select>
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">Exportar</button>
            </div>
          </div>
        </form>

        <a href="action/export_all.php" class="btn btn-success btn-sm mr-2">Exportar Todos</a>
        <a href="create.php" class="btn btn-success btn-sm">+ Novo Eleitor</a>

      </div>
    </div>
  </section>

   



  </section>

  <section class="content">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Lista de Eleitores</h3>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>Nome</th>
              <th>CPF</th>
              <th>Candidato</th>
              <th>Bairro</th>
              <th>CEP</th>
              <th>Necessidade</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['name'] ?? '—') ?></td>
              <td><?= htmlspecialchars(formatCPF($row['cpf'])) ?></td>
              <td><?= htmlspecialchars($row['candidate_name'] ?? '—') ?></td>
              <td><?= htmlspecialchars($row['neighborhood'] ?? '—') ?></td>
              <td><?= htmlspecialchars($row['cep'] ?? '—') ?></td>
              <td><?= htmlspecialchars($row['necessity'] ?? '—') ?></td>
              <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id'] ?>)">Excluir</button>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <div class="card-footer clearfix d-flex justify-content-between align-items-center">
  <!-- Limite por página -->
  <div class="d-flex align-items-center">
    <form method="get" class="form-inline m-0 mr-3">
      <label for="limitSelect" class="mb-0 mr-2 font-weight-bold">Exibir:</label>
      <select id="limitSelect" name="limit" onchange="this.form.submit()" class="form-control form-control-sm">
        <?php foreach ($limitOptions as $opt): ?>
          <option value="<?= $opt ?>" <?= $limit == $opt ? 'selected' : '' ?>><?= $opt ?></option>
        <?php endforeach; ?>
      </select>
      <input type="hidden" name="page" value="<?= $page ?>">
    </form>

    <div class="text-muted small">
      Total: <strong><?= $total ?></strong> eleitores
    </div>
  </div>

  <!-- Paginação -->
  <ul class="pagination pagination-sm m-0">
    <?php if ($page > 1): ?>
      <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>">«</a></li>
    <?php endif; ?>

    <?php
      $visiblePages = 5;
      $start = max(1, $page - floor($visiblePages / 2));
      $end = min($totalPages, $start + $visiblePages - 1);

      if ($start > 1) {
          echo '<li class="page-item"><a class="page-link" href="?page=1&limit=' . $limit . '">1</a></li>';
          if ($start > 2) {
              echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
          }
      }

      for ($i = $start; $i <= $end; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
        </li>
    <?php endfor;

      if ($end < $totalPages) {
          if ($end < $totalPages - 1) {
              echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
          }
          echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . '&limit=' . $limit . '">' . $totalPages . '</a></li>';
      }
    ?>

    <?php if ($page < $totalPages): ?>
      <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>">»</a></li>
    <?php endif; ?>
  </ul>
</div>
    </div>
  </section>
</div>




<?php include("../../layout/footer.php"); ?>


