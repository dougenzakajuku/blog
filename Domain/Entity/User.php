<?php
namespace Domain\Entity;

// use Required\UserId;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Email;
// use Required\Email;

final class User
{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct(
        ?UserId $id,
        string $name,
        Email $email,
        string $password
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function id(): ?UserId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
