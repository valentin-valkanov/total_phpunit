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
    $entityManager = new EntityManager($conn, $config);


// This should ideally be stored elsewhere...be sure not to push this file to a public repo
$bearerToken = 'Bearer AAAAAAAAAAAAAAAAAAAAAFrkuwEAAAAAcErr1rfqkwnf1Ki%2Bq3XityTJeDo%3DW1xL72z1wDpSAWJv6zIWIt0LxVFD9rL0wumMKTHCpjALqunb26';

$httpClient = HttpClient::create([
    'headers' => ['Authorization' => $bearerToken]
]);
