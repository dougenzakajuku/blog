<?php

namespace Domain\DomainService;

class KakeiboListMaker
{
    public function __construct(
        private array $incomeEntities,
        private array $spendingEntities
    ) {}

    public function createKakeiboList(): array
    {
        for ($i = 1; $i <= 12; $i++) {
            $total = 0;
            $income = $this->resolveTotalMonthAmount($this->incomeEntities, $i);
            $spending = $this->resolveTotalMonthAmount($this->spendingEntities, $i);
            $total += ($income - $spending);
            $kakeiboList[] = [
                'month' => $i,
                'income' => $income,
                'spending' => $spending,
                'total' => $total
            ];
        }

        return $kakeiboList;
    }

    private function resolveTotalMonthAmount(array $entities, int $month): int
    {
        $total = 0;
        foreach ($entities as $entity) {
            $date = $entity->accrualDate();
            if ($date->format('n') == $month){
                $total += intval($entity->amount()->value());
            }
        }
        return $total;
    }
}
