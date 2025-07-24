<?php

// Detecta se está rodando no GitHub Actions
$isCI = getenv('GITHUB_ACTIONS') === 'true';

// Define host do banco de dados dependendo do ambiente
$host = $isCI ? '127.0.0.1' : 'db';  // 👈 importante
$user = 'admin';
$pass = 'admin123';
$dbname = 'db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}