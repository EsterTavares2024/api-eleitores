<?php

// admin/api/customer/create.php

header('Content-Type: application/json');

include("../../../config/db.php");

// Verifica se o token está presente
$headers = getallheaders();
if (!isset($headers['Authorization']) || !str_starts_with($headers['Authorization'], 'Bearer ')) {
    http_response_code(401);
    echo json_encode(['error' => 'Token ausente ou formato incorreto.']);
    exit;
}

$token = trim(str_replace('Bearer', '', $headers['Authorization']));

// Busca o usuário pelo token (tabela tokens)
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

// Função para validar CPF com dígito verificador
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

// Captura o JSON do corpo da requisição
$body = json_decode(file_get_contents("php://input"), true);

$required = ['name', 'cpf', 'candidate_id', 'neighborhood', 'cep', 'necessity'];
foreach ($required as $field) {
    if (empty($body[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Campo obrigatório ausente: $field"]);
        exit;
    }
}

$cpf = preg_replace('/\D/', '', $body['cpf']);
if (!isValidCPF($cpf)) {
    http_response_code(400);
    echo json_encode(['error' => 'CPF inválido.']);
    exit;
}

// Valida se o candidato pertence ao usuário
$stmt = $conn->prepare("SELECT id FROM candidates WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $body['candidate_id'], $user_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Candidato inválido ou não pertence ao usuário.']);
    exit;
}
$stmt->close();

// Verifica duplicidade de CPF para o mesmo usuário
$stmt = $conn->prepare("SELECT id FROM customers WHERE cpf = ? AND created_by = ?");
$stmt->bind_param("si", $cpf, $user_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode(['error' => 'CPF já cadastrado para este usuário.']);
    exit;
}
$stmt->close();

$stmt = $conn->prepare("INSERT INTO customers (name, cpf, candidate_id, created_by) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssii", $body['name'], $cpf, $body['candidate_id'], $user_id);
$stmt->execute();
$customer_id = $stmt->insert_id;
$stmt->close();

$stmt2 = $conn->prepare("INSERT INTO addresses (customer_id, neighborhood, cep, necessity) VALUES (?, ?, ?, ?)");
$stmt2->bind_param("isss", $customer_id, $body['neighborhood'], $body['cep'], $body['necessity']);
$stmt2->execute();
$stmt2->close();

http_response_code(201);
echo json_encode([
    'success' => true,
    'message' => 'Eleitor cadastrado com sucesso.'
]);
exit;
