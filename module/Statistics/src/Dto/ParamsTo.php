<?php

namespace Statistics\Dto;

use DateTime;

/**
 * Class OptionTo
 *
 * @package Statistics\Dto
 */
class ParamsTo
{

    /**
     * @var string
     */
    private string $statName;

    /**
     * @var DateTime
     */
    private DateTime $startDate;

    /**
     * @var DateTime
     */
    private DateTime $endDate;

    /**
     * @return string|null
     */
    public function getStatName(): ?string
    {
        return $this->statName;
    }

    /**
     * @return DateTime|null
     */
    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    /**
     * @return DateTime|null
     */
    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    /**
     * @param string $statName
     *
     * @return $this
     */
    public function setStatName(string $statName): self
    {
        $this->statName = $statName;

        return $this;
    }

    /**
     * @param DateTime $startDate
     *
     * @return $this
     */
    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @param DateTime $endDate
     *
     * @return $this
     */
    public function setEndDate(DateTime $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
