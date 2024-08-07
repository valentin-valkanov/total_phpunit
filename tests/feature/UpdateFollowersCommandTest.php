<?php declare(strict_types=1);

namespace App\Tests\feature;

use App\Command\UpdateFollowersCommand;
use App\Entity\TwitterAccount;
use App\Http\ApplicationClientInterface;
use App\Http\TwitterClient;
use App\Tests\DatabaseDependantTestCase;

class UpdateFollowersCommandTest extends DatabaseDependantTestCase
{
    private const GCT_ID = 12345;
    private const PHPUNIT_ID = 54321;

    /** @test */
    public function the_update_followers_process_completes_correctly(): void
    {
        /********************************** SETUP **********************************/

        // Create Mock ApplicationClient
        $applicationClient = $this->createMock(ApplicationClientInterface::class);
        // TwitterClient
        $twitterClient = new TwitterClient($applicationClient);

        // Account ID's for GCT and PHPUnit
        $accountIds = [self::GCT_ID, self::PHPUNIT_ID];

        // TwitterAccount records in DB
        $gctAccount = new TwitterAccount();
        $gctAccount->setUsername('garyclarketech');
        $gctAccount->setTwitterAccountId(self::GCT_ID);
        $gctAccount->setFollowerCount(100);
        $gctAccount->setCreatedAt(date_create_immutable('2021-01-01'));
        $this->entityManager->persist($gctAccount);

        $phpUnitAcct = new TwitterAccount();
        $phpUnitAcct->setUsername('phpunit');
        $phpUnitAcct->setTwitterAccountId(self::PHPUNIT_ID);
        $phpUnitAcct->setFollowerCount(1000);
        $phpUnitAcct->setCreatedAt(date_create_immutable('2021-01-01'));
        $this->entityManager->persist($phpUnitAcct);

        $this->entityManager->flush();

        // Mock ApplicationClient get method return values * 2
        $applicationClient->expects($this->exactly(2))
            ->method('get')
            ->will($this->onConsecutiveCalls(
                '{"data":{"public_metrics":{"followers_count":500,"following_count":100,"tweet_count":100,"listed_count":100},"name":"Gary Clarke","id":'
                . self::GCT_ID . ',"username":"garyclarketech"}}',
                '{"data":{"public_metrics":{"followers_count":2000,"following_count":100,"tweet_count":100,"listed_count":100},"name":"PHPUnit","id":'
                . self::PHPUNIT_ID . ',"username":"phpunit"}}'
            ));

        // Create UpdateFollowersCommand
        $updateFollowersCommand = new UpdateFollowersCommand(
            $this->entityManager,
            $twitterClient,
            $accountIds,
            date_create_immutable('2022-01-01')
        );


        /********************************** DO SOMETHING **********************************/

        $updateFollowersCommand->execute();

        /********************************** MAKE ASSERTIONS *****************************/

        $this->assertDatabaseHasEntity(TwitterAccount::class, [
            'twitterAccountId' => self::GCT_ID,
            'username'         => $gctAccount->getUsername(),
            'tweetCount'       => 100,
            'listedCount'      => 100,
            'followingCount'   => 100,
            'followerCount'    => 500,
            'followersPerWeek' => 7
        ]);

        $this->assertDatabaseHasEntity(TwitterAccount::class, [
            'twitterAccountId' => self::PHPUNIT_ID,
            'username'         => $phpUnitAcct->getUsername(),
            'tweetCount'       => 100,
            'listedCount'      => 100,
            'followingCount'   => 100,
            'followerCount'    => 2000,
            'followersPerWeek' => 19
        ]);
    }
}