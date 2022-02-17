<?php

namespace SocialPost\Dto;

/**
 * Class ParamsTo
 * @package SocialPost\Dto
 */
class FetchParamsTo
{
    /**
     * FetchParamsTo constructor.
     *
     * @param int $pageLimit
     * @param int $pageOffset
     */
    public function __construct(
        private readonly int $pageLimit,
        private readonly int $pageOffset = 1
    ) {
    }

    /**
     * @return int
     */
    public function getPageLimit(): int
    {
        return $this->pageLimit;
    }

    /**
     * @return int
     */
    public function getPageOffset(): int
    {
        return $this->pageOffset;
    }
}
