<?php

namespace Domain\ValueObject;

final class Year
{
    private $value;

    public function __construct(int $value)
    {
        if ($value <= 0){
            throw new Exception('不適切な値です。');
        }
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}
