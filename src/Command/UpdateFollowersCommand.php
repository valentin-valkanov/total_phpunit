<?php declare(strict_types=1);

namespace App\Command;

use App\Http\TwitterClient;
use App\Entity\TwitterAccount;
use App\Statistics\TwitterStatisticsCalculator;
use App\Utility\DateHelper;
use Doctrine\ORM\EntityManagerInterface;

class UpdateFollowersCommand
{
    private array $accountIds;
    private TwitterClient $twitterClient;
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        TwitterClient $twitterClient,
        array $accountIds
    )
    {
        $this->entityManager = $entityManager;
        $this->twitterClient = $twitterClient;
        $this->accountIds = $accountIds;
    }

    public function execute(): void
    {
        foreach ($this->accountIds as $accountId) {

            // 1. ping twitter api for user data (TwitterClient::getUserById())
            $user = $this->twitterClient->getUserById($accountId);

            // 2. Calculate number of new followers per week since last check
            $repo = $this->entityManager->getRepository(TwitterAccount::class);
            $lastRecord = $repo->lastRecord($accountId);

            $newFollowersPerWeek = (new TwitterStatisticsCalculator(new DateHelper()))
                ->newFollowersPerWeek($lastRecord, $user['public_metrics']['followers_count'], date_create());

            // 3. Create a new record in DB with updated values
            $repo->addFromArray($user);
        }

        $this->entityManager->flush();

        fwrite(STDOUT, 'Process complete' . PHP_EOL);
    }
}