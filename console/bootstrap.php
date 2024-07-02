<?php // console/bootstrap.php (version2 updated May 2023)
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpClient\HttpClient;

require __DIR__ . '/../vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__ . '/../src'),
    isDevMode: true
);

// database configuration parameters
$conn = DriverManager::getConnection([
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'twitter_demo',
    'host'     => '127.0.0.1'
], $config);

// obtaining the entity manager
try {
    $entityManager = new EntityManager($conn, $config);
    echo "EntityManager setup successfully.\n";
} catch (Exception $e) {
    echo "Failed to setup EntityManager: " . $e->getMessage() . "\n";
    exit(1);
}

// This should ideally be stored elsewhere...be sure not to push this file to a public repo
$bearerToken = 'Bearer <YOUR FAKE TOKEN GOES HERE>';

$httpClient = HttpClient::create([
    'headers' => ['Authorization' => $bearerToken]
]);
