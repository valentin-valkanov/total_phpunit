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
$bearerToken = 'Bearer AAAAAAAAAAAAAAAAAAAAAFrkuwEAAAAASd1QD68V2%2BGUi%2BQjp%2FaZPjfNJsA%3D7wgJIzXgFWH3MGavMXZkDEg2rEoEG718tOYJwa1uDQRRLBW3xP';

$httpClient = HttpClient::create([
    'headers' => ['Authorization' => $bearerToken]
]);
