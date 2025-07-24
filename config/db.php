<?php

$host = getenv('DB_HOST') ?: '127.0.0.1';
$dbname = getenv('DB_NAME') ?: 'db';
$user = getenv('DB_USER') ?: 'admin';
$pass = getenv('DB_PASS') ?: 'admin123';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
