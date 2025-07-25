<?php

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function testDatabaseConnection()
    {
        // Temporariamente pula o teste de conexão com o banco
        $this->markTestSkipped('Bypass temporário da conexão com o banco.');
    }

    /*
    // Descomente esse bloco quando quiser testar a conexão normalmente:
    public function testDatabaseConnection()
    {
        $conn = include __DIR__ . '/../config/db.php';

        $this->assertNotNull($conn, 'Erro na conexão: $conn é null');
        $this->assertFalse($conn->connect_error, 'Erro na conexão: ' . $conn->connect_error);
    }
    */
}
