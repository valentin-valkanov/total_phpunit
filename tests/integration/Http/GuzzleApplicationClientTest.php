<?php declare(strict_types=1);

namespace App\Tests\integration\Http;

use App\Http\ApplicationClientException;
use App\Http\GuzzleApplicationClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * @group external
 */
class GuzzleApplicationClientTest extends TestCase
{
    private const PHPUNIT_ID = 19057969;
    private const BASE_URL = 'https://api.twitter.com/2/';

    /** @test */
    public function testGetRetrievesTheCorrectDataFromTheTwitterApi(): void
    {
        // Setup

        $guzzleClient = new Client(['headers' => ['Authorization' => BEARER_TOKEN]]);

        $guzzleApplicationClient = new GuzzleApplicationClient($guzzleClient);

        $url = self::BASE_URL . 'users/' . self::PHPUNIT_ID . '?user.fields=public_metrics';

        // Do something
        $result = $guzzleApplicationClient->get($url);
        $userData = json_decode($result, true)['data'];

        // Make assertions
        $this->assertJson($result);
        $this->assertEquals(self::PHPUNIT_ID, $userData['id']);
        $this->assertSame('phpunit', $userData['username']);
        $this->assertArrayHasKey('public_metrics', $userData);
        $this->assertArrayHasKey('followers_count', $userData['public_metrics']);

    }

    public function the_correct_exception_is_thrown_when_a_fake_bearer_token_is_sent(): void
    {
        // Setup
        $guzzleClient = new Client(['headers' => ['Authorization' => 'fake_bearer_token']]);

        $guzzleApplicationClient = new GuzzleApplicationClient($guzzleClient);

        $url = self::BASE_URL . 'users/' . self::PHPUNIT_ID . '?user.fields=public_metrics';

        $this->expectExceptionCode(401);
        $this->expectException(ApplicationClientException::class);
        $this->expectExceptionMessage('Unauthorized');

        // Do something
        $guzzleApplicationClient->get($url);
    }
}