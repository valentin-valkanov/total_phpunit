<?php // console/update-followers.php

use App\Command\UpdateFollowersCommand;
use App\Http\SymfonyHttpApplicationClient;
use App\Http\TwitterClient;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

$applicationClient = new SymfonyHttpApplicationClient($httpClient);
$twitterClient = new TwitterClient($applicationClient);

$command = new UpdateFollowersCommand(
    $entityManager,
    $twitterClient,
    [19057969, 1285294171033604101]
);

$command->execute();