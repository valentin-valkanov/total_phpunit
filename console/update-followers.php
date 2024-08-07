<?php // console/update-followers.php

use App\Command\UpdateFollowersCommand;
use App\Http\SymfonyHttpApplicationClient;
use App\Http\TwitterClient;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

$applicationClient = new \App\Http\GuzzleApplicationClient($httpClient);
$twitterClient = new \App\Http\TwitterClient($applicationClient);

$command = new \App\Command\UpdateFollowersCommand(
    $entityManager,
    $twitterClient,
    [19057969, 1285294171033604101],
    date_create_immutable()
);

$command->execute();