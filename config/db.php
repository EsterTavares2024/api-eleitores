<?php
$host = 'db'; // Nome do serviço no docker-compose
$user = 'Admin';
$pass = 'Admin#25';
$dbname = 'db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
