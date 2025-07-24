<?php

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Usuário não autenticado.']);
    exit;
}

include("../../../config/db.php");

$userId = $_SESSION['user_id'];

// Gera um novo token aleatório
$newToken = base64_encode(random_bytes(32));

// Verifica se já existe um token
$stmt = $conn->prepare("SELECT id FROM api_tokens WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Atualiza token existente
    $stmt->close();
    $update = $conn->prepare("UPDATE api_tokens SET token = ?, created_at = NOW() WHERE user_id = ?");
    $update->bind_param("si", $newToken, $userId);
    $update->execute();
    $update->close();
} else {
    // Cria novo token
    $stmt->close();
    $insert = $conn->prepare("INSERT INTO api_tokens (user_id, token) VALUES (?, ?)");
    $insert->bind_param("is", $userId, $newToken);
    $insert->execute();
    $insert->close();
}

echo json_encode(['success' => true, 'token' => $newToken]);
exit;
