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

// Opções de limite por página
$limitOptions = [10, 25, 50, 100];
$defaultLimit = 10;

$limit = isset($_GET['limit']) && in_array((int)$_GET['limit'], $limitOptions)
    ? (int)$_GET['limit']
    : $defaultLimit;

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Total de registros do usuário
$countStmt = $conn->prepare("SELECT COUNT(*) as total FROM candidates WHERE created_by = ?");
$countStmt->bind_param("i", $userId);
$countStmt->execute();
$countResult = $countStmt->get_result()->fetch_assoc();
$totalPages = ceil($countResult['total'] / $limit);
$countStmt->close();

// Buscar candidatos do usuário
$stmt = $conn->prepare("SELECT * FROM candidates WHERE created_by = ? ORDER BY name ASC LIMIT ? OFFSET ?");
$stmt->bind_param("iii", $userId, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="d-flex justify-content-between align-items-center">
      <h1>Lista de Candidatos</h1>
      <div>
        <a href="create.php" class="btn btn-success">+ Adicionar Candidato</a>
        <button class="btn btn-danger" onclick="confirmDeleteAll()">Excluir Todos</button>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Candidatos Cadastrados</h3>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Partido</th>
              <th>Descrição</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['name'] ?? '—') ?></td>
                <td><?= htmlspecialchars($row['party'] ?? '—') ?></td>
                <td><?= htmlspecialchars($row['description'] ?? '—') ?></td>
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
            Total: <strong><?= $countResult['total'] ?></strong> candidatos
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
