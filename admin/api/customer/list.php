<?php
header('Content-Type: application/json');
include("../../../config/db.php");

// Verifica o token
$headers = getallheaders();
if (!isset($headers['Authorization']) || !str_starts_with($headers['Authorization'], 'Bearer ')) {
    http_response_code(401);
    echo json_encode(['error' => 'Token ausente ou formato incorreto.']);
    exit;
}

$token = trim(str_replace('Bearer', '', $headers['Authorization']));
$stmt = $conn->prepare("SELECT user_id FROM api_tokens WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    http_response_code(403);
    echo json_encode(['error' => 'Token inválido.']);
    exit;
}

$user_id = $user['user_id'];

// Lista os eleitores do usuário
$query = "
    SELECT customers.id, customers.name, customers.cpf, candidates.name AS candidato,
           addresses.neighborhood, addresses.cep, addresses.necessity, customers.created_at
    FROM customers
    LEFT JOIN candidates ON candidates.id = customers.candidate_id
    LEFT JOIN addresses ON addresses.customer_id = customers.id
    WHERE customers.created_by = ?
    ORDER BY customers.created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['success' => true, 'data' => $data]);
exit;
