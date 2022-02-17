<?php

namespace Statistics\Service;

use SocialPost\Dto\SocialPostTo;
use Statistics\Calculator\Factory\StatisticsCalculatorFactory;
use Statistics\Dto\ParamsTo;
use Statistics\Dto\StatisticsTo;
use Traversable;

/**
 * Class PostStatisticsService
 * @package Statistics
 */
class StatisticsService
{

    /**
     * StatisticsService constructor.
     *
     * @param StatisticsCalculatorFactory $factory
     */
    public function __construct(
        private readonly StatisticsCalculatorFactory $factory
    ) {
    }

    /**
     * @param Traversable $posts
     * @param ParamsTo[] $params
     *
     * @return StatisticsTo
     */
    public function calculateStats(Traversable $posts, array $params): StatisticsTo
    {
        $calculator = $this->factory->create($params);

        foreach ($posts as $post) {
            if (!$post instanceof SocialPostTo) {
                continue;
            }
            $calculator->accumulateData($post);
        }

        return $calculator->calculate();
    }
}
