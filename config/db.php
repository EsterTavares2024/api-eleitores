<?php

$host = 'db';
$port = '3306';
$dbname = 'db';
$user = 'admin';
$pass = 'admin123';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    // Em vez de die, lançamos uma exceção para capturar no teste
    throw new Exception("Erro na conexão: " . $conn->connect_error);
}

return $conn;