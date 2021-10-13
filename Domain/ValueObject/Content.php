<?php

namespace Domain\ValueObject;

final class Content
{
    private $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_STRING)) {
            throw new Exception('投稿を正しい形式で入力してください');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}