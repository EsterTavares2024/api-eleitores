<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

include("../../../config/db.php");

$customer_id = intval($_GET['id'] ?? 0);
$user_id     = intval($_SESSION['user_id']);

// Verifica se o eleitor pertence ao usuário
$stmt = $conn->prepare("SELECT id FROM customers WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $customer_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    $message = urlencode("Eleitor não encontrado ou você não tem permissão para excluí-lo.");
    header("Location: ../index.php?error=notfound&message=" . $message);
    exit;
}
$stmt->close();

// Deleta o customer (o endereço será deletado automaticamente por ON DELETE CASCADE)
$stmt = $conn->prepare("DELETE FROM customers WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $customer_id, $user_id);
$stmt->execute();
$stmt->close();

header("Location: ../index.php?success=1");
exit;
