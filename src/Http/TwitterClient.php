<?php declare(strict_types=1);

namespace App\Http;

class TwitterClient
{
    private ApplicationClientInterface $applicationClient;

    public function __construct(ApplicationClientInterface $applicationClient)
    {
        $this->applicationClient = $applicationClient;
    }

    private const API_V2_URL = 'https://api.twitter.com/2/';

    public function getUserById($accountId): array
    {
        $url = self::API_V2_URL . 'users/' . $accountId . '?user.fields=public_metrics';

        $user = $this->applicationClient->get($url);

        return json_decode($user, true)['data'];
    }
}