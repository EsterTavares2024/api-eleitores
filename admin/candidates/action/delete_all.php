<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

include("../../../config/db.php");

$userId = $_SESSION['user_id'];

// Verifica se há eleitores vinculados aos candidatos criados por este usuário
$check = $conn->prepare("
    SELECT COUNT(*) as total 
    FROM customers 
    WHERE created_by = ?
");
$check->bind_param("i", $userId);
$check->execute();
$result = $check->get_result();
$data = $result->fetch_assoc();
$check->close();

if ($data['total'] > 0) {
    header("Location: ../index.php?error=all");
    exit;
}

// Nenhum eleitor vinculado aos candidatos deste usuário → pode deletar
$delete = $conn->prepare("DELETE FROM candidates WHERE created_by = ?");
$delete->bind_param("i", $userId);
$delete->execute();
$delete->close();

header("Location: ../index.php?success=1");
exit;
