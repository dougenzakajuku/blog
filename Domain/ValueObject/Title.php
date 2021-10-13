<?php

namespace Domain\ValueObject;

final class Title
{
    private $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_STRING)) {
            throw new Exception('タイトルを正しい形式で入力してください');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}