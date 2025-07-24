<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../../../config/db.php");

function isValidCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

$name         = trim($_POST['name'] ?? '');
$cpf          = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
$candidate_id = intval($_POST['candidate_id'] ?? 0);
$neighborhood = trim($_POST['neighborhood'] ?? '');
$cep          = trim($_POST['cep'] ?? '');
$necessity    = trim($_POST['necessity'] ?? '');
$user_id      = intval($_SESSION['user_id']);

if (!isValidCPF($cpf)) {
    header("Location: ../create.php?error=invalidcpf");
    exit;
}

if (!$name || !$cpf || !$candidate_id || !$neighborhood || !$cep || !$necessity) {
    header("Location: ../create.php?error=empty");
    exit;
}

// ✅ Verifica duplicidade de CPF APENAS do mesmo usuário
$check = $conn->prepare("SELECT id FROM customers WHERE cpf = ? AND created_by = ?");
$check->bind_param("si", $cpf, $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    header("Location: ../create.php?error=cpf");
    exit;
}
$check->close();

// Salvar cliente
$stmt = $conn->prepare("INSERT INTO customers (name, cpf, candidate_id, created_by) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    die("Erro na preparação da query de cliente: " . $conn->error);
}
$stmt->bind_param("ssii", $name, $cpf, $candidate_id, $user_id);
$stmt->execute();
$customer_id = $stmt->insert_id;
$stmt->close();

// Salvar endereço
$stmt2 = $conn->prepare("INSERT INTO addresses (customer_id, neighborhood, cep, necessity) VALUES (?, ?, ?, ?)");
if (!$stmt2) {
    die("Erro na preparação da query de endereço: " . $conn->error);
}
$stmt2->bind_param("isss", $customer_id, $neighborhood, $cep, $necessity);
$stmt2->execute();
$stmt2->close();

header("Location: ../index.php?success=1");
exit;
