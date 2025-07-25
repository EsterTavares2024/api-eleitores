<?php
use PHPUnit\Framework\TestCase;

public function testDatabaseConnection()
{
    $this->markTestSkipped('Bypass temporário da conexão com o banco.');
}


class DatabaseConnectionTest extends TestCase
{
    public function testDatabaseConnection()
    {
        try {
            $conn = include __DIR__ . '/../config/db.php';
            $this->assertNotNull($conn);
            $this->assertInstanceOf(mysqli::class, $conn);
        } catch (Exception $e) {
            $this->fail("Erro na conexão: " . $e->getMessage());
        }
    }
}
