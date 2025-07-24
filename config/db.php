<?php

// Detecta se está rodando no GitHub Actions
$isCI = getenv('GITHUB_ACTIONS') === 'true';

// Se estiver rodando no CI, usa o nome do serviço Docker MySQL
$host = $isCI ? 'mysql' : '127.0.0.1'; 

$user   = 'Admin';
$pass   = 'Admin#25';
$dbname = 'db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
