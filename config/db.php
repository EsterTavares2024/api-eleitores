<?php
$host = 'db';
$port = '3306';
$dbname = 'db';
$user = 'admin';
$pass = 'admin123';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

return $conn;