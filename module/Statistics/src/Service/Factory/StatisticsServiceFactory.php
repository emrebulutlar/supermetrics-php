<?php

namespace Statistics\Service\Factory;

use JetBrains\PhpStorm\Pure;
use Statistics\Calculator\Factory\StatisticsCalculatorFactory;
use Statistics\Service\StatisticsService;

/**
 * Class StatisticsServiceFactory
 *
 * @package Statistics\Service\Factory
 */
class StatisticsServiceFactory
{

    /**
     * @return StatisticsService
     */
    #[Pure] public static function create(): StatisticsService
    {
        $calculatorFactory = new StatisticsCalculatorFactory();

        return new StatisticsService($calculatorFactory);
    }
}
