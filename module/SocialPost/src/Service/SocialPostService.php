<?php

namespace SocialPost\Service;

use JetBrains\PhpStorm\Pure;
use SocialPost\Driver\SocialDriverInterface;
use SocialPost\Dto\FetchParamsTo;
use SocialPost\Hydrator\SocialPostHydratorInterface;
use Traversable;

/**
 * Class SocialPostService
 * @package SocialPost\Service
 */
class SocialPostService
{

    private const DEFAULT_LIMIT = 10;

    private const DEFAULT_OFFSET = 1;

    /**
     * SocialPostService constructor.
     *
     * @param SocialDriverInterface $driver
     * @param SocialPostHydratorInterface $hydrator
     */
    public function __construct(
        private readonly SocialDriverInterface $driver,
        private readonly SocialPostHydratorInterface $hydrator
    ) {
    }

    /**
     * @param FetchParamsTo|null $fetchParams
     *
     * @return Traversable
     */
    public function fetchPosts(FetchParamsTo $fetchParams = null): Traversable
    {
        $fetchParams = $fetchParams ?? $this->getDefaultParams();

        for ($index = 0; $index < $fetchParams->getPageLimit(); $index++) {
            $page = (int)$index + $fetchParams->getPageOffset();

            $posts = $this->driver->fetchPostsByPage($page);

            foreach ($posts as $postData) {
                yield $this->hydrator->hydrate($postData);
            }
        }
    }

    /**
     * @return FetchParamsTo
     */
    #[Pure] private function getDefaultParams(): FetchParamsTo
    {
        return new FetchParamsTo(self::DEFAULT_LIMIT, self::DEFAULT_OFFSET);
    }
}
