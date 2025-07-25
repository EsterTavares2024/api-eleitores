<?php

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function testDatabaseConnection()
    {
        // Garante que o arquivo de conexão será incluído corretamente
        $conn = require __DIR__ . '/../config/db.php';

        // Verifica se retornou uma instância válida de mysqli
        $this->assertInstanceOf(mysqli::class, $conn);

        // Verifica se a conexão está realmente aberta
        $this->assertFalse($conn->connect_error, "Erro na conexão: " . $conn->connect_error);

        // Fecha a conexão ao final do teste (boas práticas)
        $conn->close();
    }
}
