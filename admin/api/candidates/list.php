<?php

header('Content-Type: application/json');

include("../../../config/db.php");

// Verifica token
$headers = getallheaders();
if (!isset($headers['Authorization']) || !str_starts_with($headers['Authorization'], 'Bearer ')) {
    http_response_code(401);
    echo json_encode(['error' => 'Token ausente ou formato incorreto.']);
    exit;
}

$token = trim(str_replace('Bearer', '', $headers['Authorization']));

// Busca user_id a partir do token na tabela api_tokens
$stmt = $conn->prepare("SELECT user_id FROM api_tokens WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    http_response_code(403);
    echo json_encode(['error' => 'Token inválido.']);
    exit;
}

$user_id = $user['user_id'];

// Busca os candidatos desse usuário
$stmt = $conn->prepare("SELECT id, name, party, description FROM candidates WHERE created_by = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

http_response_code(200);
echo json_encode([
    'success' => true,
    'data'    => $data
]);
