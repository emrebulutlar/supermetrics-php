<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class AveragePostsPerUserPerMonth extends AbstractCalculator
{

    protected const UNITS = 'posts';

    private array $users = [];
    private int $totalPosts = 0;

    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $this->users[$postTo->getAuthorId()] = $postTo->getAuthorId();
        $this->totalPosts++;
    }

    protected function doCalculate(): StatisticsTo
    {
        return (new StatisticsTo())->setValue( $this->totalPosts / count($this->users));
    }
}
