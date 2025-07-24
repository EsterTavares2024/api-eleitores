<?php

header('Content-Type: application/json');
include("../../../config/db.php");

// Token
$headers = getallheaders();
if (!isset($headers['Authorization']) || !str_starts_with($headers['Authorization'], 'Bearer ')) {
    http_response_code(401);
    echo json_encode(['error' => 'Token ausente ou formato incorreto.']);
    exit;
}

$token = trim(str_replace('Bearer', '', $headers['Authorization']));
$stmt  = $conn->prepare("SELECT user_id FROM api_tokens WHERE token = ?");
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

// Verifica se o ID foi enviado
$body        = json_decode(file_get_contents("php://input"), true);
$customer_id = intval($body['id'] ?? 0);
if (!$customer_id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do eleitor não fornecido.']);
    exit;
}

// Verifica se o eleitor pertence ao usuário
$stmt = $conn->prepare("SELECT id FROM customers WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $customer_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Eleitor não encontrado ou não pertence ao usuário.']);
    exit;
}
$stmt->close();

// Deleta (endereços são removidos por ON DELETE CASCADE)
$stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$stmt->close();

http_response_code(200);
echo json_encode(['success' => true, 'message' => 'Eleitor deletado com sucesso.']);
exit;
