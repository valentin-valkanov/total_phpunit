<?php declare(strict_types=1);

namespace App\Tests\Statistics;

use App\Entity\TwitterAccount;
use App\Statistics\TwitterStatisticsCalculator;
use App\Utility\DateHelper;
use PHPUnit\Framework\TestCase;

class TwitterStatisticsCalculatorTest extends TestCase
{
    /** @test  */
    public function newFollowersPerWeek_calculates_the_correct_value()
    {
        //Setup
        $checkDate = date_create('2022-01-01');
        $createdAt = date_create('2021-01-01');
        $lastRecord = new TwitterAccount();
        $lastRecord->setFollowerCount(1000);
        $lastRecord->setCreatedAt($createdAt);
        $currentFollowerCount = 2000;

        $dateHelper = $this->createMock(DateHelper::class);

        $dateHelper->expects($this->once())
            ->method("weeksBetweenDates")
            ->with($checkDate, $createdAt)
            ->willReturn(52);

        $twitterStatisticsCalculator = new TwitterStatisticsCalculator($dateHelper);

        //Do Something
       $newFollowersPerWeek = $twitterStatisticsCalculator->newFollowersPerWeek($lastRecord, $currentFollowerCount, $checkDate);

        //Make Assertions
        $this->assertSame(19, $newFollowersPerWeek);
    }

    /** @test */
    public function newFollowersPerWeek_returns_0_when_last_record_is_null()
    {
        //Setup
        $twitterStatisticsCalculator = new TwitterStatisticsCalculator(new DateHelper());
        //Do Something
        $newFollowersPerWeek = $twitterStatisticsCalculator->newFollowersPerWeek(null, 1000, date_create('2021-01-01'));

        //Make Assertions
        $this->assertSame(0, $newFollowersPerWeek);
    }
}