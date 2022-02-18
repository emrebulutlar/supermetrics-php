<?php

declare(strict_types=1);

namespace Tests\unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use SocialPost\Dto\SocialPostTo;
use SocialPost\Hydrator\FictionalPostHydrator;
use Statistics\Calculator\AveragePostsPerUserPerMonth;
use Statistics\Dto\ParamsTo;
use Statistics\Dto\StatisticsTo;
use Statistics\Enum\StatsEnum;
use Statistics\Service\Factory\StatisticsServiceFactory;
use Statistics\Service\StatisticsService;
use Traversable;

/**
 * Class ATestTest
 * @package Tests\unit
 */
class AveragePostsPerUserPerMonthTest extends TestCase
{

    public function testPostsShouldBeInstanceOfTraversable()
    {
        $posts = $this->makePosts();

        $this->assertInstanceOf(Traversable::class, $posts);
    }

    public function testPostShouldBeInstanceOfSocialPostTo()
    {

        $posts = $this->makePosts();

        foreach ($posts as $post) {
            $this->assertInstanceOf(SocialPostTo::class, $post);
        }
    }

    /**
     * @test
     */
    public function testIfStaticsAveragePostsPerUserPerMonthCalculates(): void
    {
        $statsService = StatisticsServiceFactory::create();

        $this->assertInstanceOf(StatisticsService::class, $statsService);

        // prepare params.
        $posts = $this->makePosts();
        $params = $this->makeCalculatorParams("2018-08-11");

        $stats = $statsService->calculateStats($posts, $params);

        $this->assertInstanceOf(StatisticsTo::class, $stats);
        $this->assertIsArray($stats->getChildren());
        $this->assertCount(1, $stats->getChildren());

        $averagePostsPerUserPerMonth = $stats->getChildren()[0];

        $this->assertInstanceOf(StatisticsTo::class, $averagePostsPerUserPerMonth);
        $this->assertEquals(StatsEnum::AVERAGE_POST_NUMBER_PER_USER, $averagePostsPerUserPerMonth->getName());
        $this->assertEquals(1, $averagePostsPerUserPerMonth->getValue());

    }

    public function testIfStaticsAveragePostsPerUserPerMonthNotCalculates(){

        $statsService = StatisticsServiceFactory::create();

        $this->assertInstanceOf(StatisticsService::class, $statsService);

        // prepare params.
        $posts = $this->makePosts();
        $params = $this->makeCalculatorParams("2018-09-11");

        $stats = $statsService->calculateStats($posts, $params);

        $this->assertInstanceOf(StatisticsTo::class, $stats);
        $this->assertIsArray($stats->getChildren());
        $this->assertCount(1, $stats->getChildren());

        $averagePostsPerUserPerMonth = $stats->getChildren()[0];

        $this->assertInstanceOf(StatisticsTo::class, $averagePostsPerUserPerMonth);
        $this->assertEquals(StatsEnum::AVERAGE_POST_NUMBER_PER_USER, $averagePostsPerUserPerMonth->getName());
        $this->assertEquals(0, $averagePostsPerUserPerMonth->getValue());
    }

    private function makeCalculatorParams(string $date): array
    {
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $startDate = (clone $date)->modify('first day of this month');
        $endDate = (clone $date)->modify('last day of this month');

        return [
            (new ParamsTo())
                ->setStatName(StatsEnum::AVERAGE_POST_NUMBER_PER_USER)
                ->setStartDate($startDate)
                ->setEndDate($endDate),
        ];
    }

    private function makePosts(): Traversable
    {
        $posts = file_get_contents('tests/data/social-posts-response.json');
        $posts = json_decode($posts, true);

        $hydrator = new FictionalPostHydrator();
        foreach ($posts['data']['posts'] as $post) {
            yield $hydrator->hydrate($post);
        }
    }
}
