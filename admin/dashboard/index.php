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

// Totais por usuário logado
$totalCandidates = $conn->query("SELECT COUNT(*) as total FROM candidates WHERE created_by = $userId")->fetch_assoc()['total'];
$totalElectors = $conn->query("SELECT COUNT(*) as total FROM customers WHERE created_by = $userId")->fetch_assoc()['total'];

// Votos por candidato (somente os criados pelo user atual)
$votosQuery = $conn->prepare("
    SELECT c.name, COUNT(customers.id) as votos
    FROM candidates c
    LEFT JOIN customers ON customers.candidate_id = c.id AND customers.created_by = ?
    WHERE c.created_by = ?
    GROUP BY c.id
");
$votosQuery->bind_param("ii", $userId, $userId);
$votosQuery->execute();
$votosResult = $votosQuery->get_result();

$labels = [];
$data = [];
while ($row = $votosResult->fetch_assoc()) {
    $labels[] = $row['name'];
    $data[] = $row['votos'];
}
?>


<div class="content-wrapper">
  <section class="content-header">
    <h1>Dashboard</h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= $totalElectors ?></h3>
            <p>Total de Eleitores</p>
          </div>
          <div class="icon"><i class="fas fa-users"></i></div>
        </div>
      </div>
      <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= $totalCandidates ?></h3>
            <p>Total de Candidatos</p>
          </div>
          <div class="icon"><i class="fas fa-user-tie"></i></div>
        </div>
      </div>
      <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= array_sum($data) ?></h3>
            <p>Total de Votos</p>
          </div>
          <div class="icon"><i class="fas fa-vote-yea"></i></div>
        </div>
      </div>
    </div>

    <!-- Gráfico -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Votos por Candidato</h3>
      </div>
      <div class="card-body">
        <canvas id="votosChart" height="120"></canvas>
      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('votosChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Votos',
            data: <?= json_encode($data) ?>,
            borderColor: '#00c0ef',
            backgroundColor: 'rgba(0,192,239,0.2)',
            fill: true,
            tension: 0.3,
            pointBackgroundColor: '#00c0ef',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<?php include("../../layout/footer.php"); ?>
