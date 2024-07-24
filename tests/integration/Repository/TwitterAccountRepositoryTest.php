<?php declare(strict_types=1);

namespace App\Tests\integration\Repository;

use App\Entity\TwitterAccount;
use App\Repository\TwitterAccountRepository;
use App\Tests\DatabaseDependantTestCase;

class TwitterAccountRepositoryTest extends DatabaseDependantTestCase
{
    private TwitterAccountRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->entityManager->getRepository(TwitterAccount::class);
    }

    public function testLastRecordReturnsTheCorrectTwitterAccountEntity()
    {
        //Arrange
        $accountId = 99999;
        $previousAccount = new TwitterAccount();
        $previousAccount->setTwitterAccountId($accountId);
        $previousAccount->setUsername('phpunit');
        $previousAccount->setFollowerCount(1000);
        $previousAccount->setCreatedAt(date_create_immutable('2021-01-01'));
        $this->entityManager->persist($previousAccount);

        $currentAccount = new TwitterAccount();
        $currentAccount->setTwitterAccountId($accountId);
        $currentAccount->setUsername('phpunit');
        $currentAccount->setFollowerCount(1000);
        $currentAccount->setCreatedAt(date_create_immutable('2022-01-01'));
        $this->entityManager->persist($currentAccount);
        $this->entityManager->flush();

        //Act
        $lastRecord = $this->repository->lastRecord($accountId);

        //Assert
        $this->assertInstanceOf(TwitterAccount::class, $lastRecord);
        $this->assertSame($lastRecord->getId(), $currentAccount->getId());
        $this->assertSame(2, $lastRecord->getId());
    }


    public function testLastRecordReturnsNullWhenNoRecordsFound()
    {
        //Arrange
        $accountId = 99999;

        //Act
        $lastRecord = $this->repository->lastRecord($accountId);

        //Assert
        $this->assertNull($lastRecord);
    }







}