<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

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

$customer_id  = intval($_POST['id'] ?? 0);
$name         = trim($_POST['name'] ?? '');
$cpf          = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
$candidate_id = intval($_POST['candidate_id'] ?? 0);
$neighborhood = trim($_POST['neighborhood'] ?? '');
$cep          = trim($_POST['cep'] ?? '');
$necessity    = trim($_POST['necessity'] ?? '');
$user_id      = intval($_SESSION['user_id']);

if (!isValidCPF($cpf)) {
    header("Location: ../edit.php?id=$customer_id&error=invalidcpf");
    exit;
}

if (!$name || !$cpf || !$candidate_id || !$neighborhood || !$cep || !$necessity) {
    header("Location: ../edit.php?id=$customer_id&error=empty");
    exit;
}

// Verifica se já existe outro eleitor com o mesmo CPF para o mesmo usuário
$check = $conn->prepare("SELECT id FROM customers  WHERE REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') = ? AND id != ? AND created_by = ?");
$check->bind_param("sii", $cpf, $customer_id, $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    header("Location: ../edit.php?id=$customer_id&error=cpf");
    exit;
}
$check->close();

$stmt = $conn->prepare("UPDATE customers SET name = ?, cpf = ?, candidate_id = ? WHERE id = ? AND created_by = ?");
if (!$stmt) {
    die("Erro ao preparar atualização de cliente: " . $conn->error);
}
$stmt->bind_param("ssiii", $name, $cpf, $candidate_id, $customer_id, $user_id);
$stmt->execute();
$stmt->close();

$stmt2 = $conn->prepare("UPDATE addresses SET neighborhood = ?, cep = ?, necessity = ? WHERE customer_id = ?");
if (!$stmt2) {
    die("Erro ao preparar atualização de endereço: " . $conn->error);
}
$stmt2->bind_param("sssi", $neighborhood, $cep, $necessity, $customer_id);
$stmt2->execute();
$stmt2->close();


header("Location: ../index.php?success=1");
exit;
