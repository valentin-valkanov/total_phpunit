<?php declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class DatabaseDependantTestCase extends TestCase
{
    protected ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        require __DIR__ . '/connection.php';
        $this->entityManager = $entityManager;
        SchemaLoader::load($entityManager);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}