<?php
namespace Domain\Entity;

use Domain\ValueObject\IncomeId;
use Domain\ValueObject\UserId;
use Domain\ValueObject\IncomeSourceId;
use Domain\ValueObject\Amount;
use \Datetime;

class Income
{
    private $id;
    private $userId;
    private $incomeSourceId;
    private $amount;
    private $accrualDate;

    public function __construct(
        ?IncomeId $id,
        UserId $userId,
        ?IncomeSourceId $incomeSourceId,
        ?Amount $amount,
        ?DateTime $accrualDate
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->incomeSourceId = $incomeSourceId;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }

    public function id(): ?IncomeId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function incomeSourceId(): ?IncomeSourceId
    {
        return $this->incomeSourceId;
    }

    public function Amount(): ?Amount
    {
        return $this->amount;
    }

    public function accrualDate(): DateTime
    {
        return $this->accrualDate;
    }

    public function accrualDateForView(): string
    {
        return $this->accrualDate->format('Y/m/d');
    }
}
