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

    public function assertDatabaseHasEntity(string $entityName, array $criteria)
    {
        $result = $this->entityManager->getRepository($entityName)->findOneBy($criteria);

        // Assert
        $this->assertTrue((bool) $result, "A $entityName record could not be found with the supplied criteria");
    }
}