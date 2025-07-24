<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

include("../../../config/db.php");

$userId = $_SESSION['user_id']; // <- adicionado aqui

// Verifica se o ID foi passado corretamente
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../index.php?error=notfound");
    exit;
}

$id = intval($_GET['id']);

// Verifica se existem eleitores vinculados por este usuário
$check = $conn->prepare("SELECT COUNT(*) FROM customers WHERE candidate_id = ? AND created_by = ?");
$check->bind_param("ii", $id, $userId);
$check->execute();
$check->bind_result($count);
$check->fetch();
$check->close();

if ($count > 0) {
    header("Location: ../index.php?error=linked");
    exit;
}

// Deleta o candidato (desde que ele também pertença ao usuário)
$stmt = $conn->prepare("DELETE FROM candidates WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $id, $userId);
$stmt->execute();
$stmt->close();

header("Location: ../index.php?success=1");
exit;
