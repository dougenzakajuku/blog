<?php
namespace Domain\Entity;

use Domain\ValueObject\BlogId;
use Domain\ValueObject\UserId;
use Domain\ValueObject\Title;
use Domain\ValueObject\Content;

class Income
{
    private $id;
    private $userId;
    private $title;
    private $content;

    public function __construct(
        BlogId $id,
        UserId $userId,
        Title $title,
        Content $content
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
    }

    public function id(): BlogId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function content(): Content
    {
        return $this->content;
    }
}
