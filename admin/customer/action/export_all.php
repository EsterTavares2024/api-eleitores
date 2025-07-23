<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

include("../../../config/db.php");

$userId = $_SESSION['user_id']; // ✅ Restringe os dados ao tenant

// Cabeçalhos para CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=eleitores_completos.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Nome', 'CPF', 'Candidato', 'Bairro', 'CEP', 'Necessidade', 'Data de Criação']);

$query = "
    SELECT customers.name, customers.cpf, candidates.name AS candidato,
           addresses.neighborhood, addresses.cep, addresses.necessity, customers.created_at
    FROM customers
    LEFT JOIN candidates ON candidates.id = customers.candidate_id
    LEFT JOIN addresses ON addresses.customer_id = customers.id
    WHERE customers.created_by = ?
    ORDER BY customers.created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['name'],
        $row['cpf'],
        $row['candidato'],
        $row['neighborhood'],
        $row['cep'],
        $row['necessity'],
        $row['created_at'],
    ]);
}

fclose($output);
exit;
