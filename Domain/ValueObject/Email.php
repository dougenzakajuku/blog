<?php

namespace Domain\ValueObject;

final class Email
{
    private $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('メールアドレスを正しい形式で入力してください');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}