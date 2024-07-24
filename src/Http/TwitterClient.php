<?php declare(strict_types=1);

namespace App\Http;

use App\Utility\ArrayHelper;

class TwitterClient
{
    private ApplicationClientInterface $applicationClient;

    public function __construct(ApplicationClientInterface $applicationClient)
    {
        $this->applicationClient = $applicationClient;
    }

    private const API_V2_URL = 'https://api.twitter.com/2/';

    /**retrieves user information from Twitter's API using the user's account ID */
    public function getUserById($accountId): array
    {
        $url = self::API_V2_URL . 'users/' . $accountId . '?user.fields=public_metrics';

        $user = $this->applicationClient->get($url);

        return ArrayHelper::flatten(json_decode($user, true)['data']);
    }
}