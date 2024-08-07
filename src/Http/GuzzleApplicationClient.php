<?php declare(strict_types=1);

namespace App\Http;

use GuzzleHttp\ClientInterface;

class GuzzleApplicationClient implements ApplicationClientInterface
{
    public function __construct(private ClientInterface $httpClient)
    {
    }

    public function get(string $url): string
    {
        try {

            $response = $this->httpClient->request('GET', $url);

            return $response->getBody();

        } catch (\Exception $exception) {

            throw new ApplicationClientException($exception->getMessage());
        }


    }
}