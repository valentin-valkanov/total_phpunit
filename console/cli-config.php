#!/usr/bin/env php
<?php // console/cli-config.php (version2 updated May 2023)
// bin/doctrine

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

// Adjust this path to your actual bootstrap.php
require __DIR__ . '/bootstrap.php';

if (!$entityManager) {
    echo "EntityManager is not set up correctly.";
    exit(1);
}
ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);
