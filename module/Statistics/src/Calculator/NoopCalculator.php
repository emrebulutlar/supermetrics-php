<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use JetBrains\PhpStorm\Pure;
use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class NoopCalculator extends AbstractCalculator
{
    /**
     * @inheritDoc
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        // Noops!
    }

    /**
     * @inheritDoc
     */
    #[Pure] protected function doCalculate(): StatisticsTo
    {
        return new StatisticsTo();
    }
}
