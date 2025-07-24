<?php

$isCI = getenv('GITHUB_ACTIONS') === 'true';

$host = '127.0.0.1';
$user = $isCI ? 'root' : 'admin';
$pass = $isCI ? 'root' : 'admin123';
$dbname = 'db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}