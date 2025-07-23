<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

include("../../../config/db.php");

$userId = $_SESSION['user_id'];
$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$party = trim($_POST['party'] ?? '');
$description = trim($_POST['description'] ?? '');

if ($id > 0 && $name) {
    $stmt = $conn->prepare("UPDATE candidates SET name = ?, party = ?, description = ? WHERE id = ? AND created_by = ?");
    $stmt->bind_param("sssii", $name, $party, $description, $id, $userId);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../index.php");
exit;
