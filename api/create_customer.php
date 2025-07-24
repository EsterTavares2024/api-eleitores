<?php

header('Content-Type: application/json');
include("../config/db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['email'], $data['phone'])) {
    http_response_code(400);
    echo json_encode(["error" => "Dados incompletos"]);
    exit;
}

$name  = $data['name'];
$email = $data['email'];
$phone = $data['phone'];

// Por segurança, o ID do usuário poderia ser passado via token ou algo do tipo
$created_by = 1;

$stmt = $conn->prepare("INSERT INTO customers (name, email, phone, created_by) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $name, $email, $phone, $created_by);
$stmt->execute();

echo json_encode(["success" => true, "customer_id" => $stmt->insert_id]);
