<?php
use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function testDatabaseConnection()
    {
        $conn = include __DIR__ . '/../config/db.php';
        $this->assertInstanceOf(PDO::class, $conn);
    }
}
