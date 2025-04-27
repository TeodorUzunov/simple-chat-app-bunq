<?php

declare(strict_types=1);

namespace App\Domain\Message;

use JsonSerializable;

class Message implements JsonSerializable
{
    private ?int $id;

    private int $chatGroupId;

    private int $userId;

    private string $content;

    private int $created;

    public function __construct(?int $id, int $chatGroupId, int $userId, string $content, int $created)
    {
        $this->id = $id;
        $this->chatGroupId = $chatGroupId;
        $this->userId = $userId;
        $this->content = $content;
        $this->created = $created;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChatGroupId(): int
    {
        return $this->chatGroupId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreated(): int
    {
        return $this->created;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'chatGroupId' => $this->chatGroupId,
            'userId' => $this->userId,
            'content' => $this->content,
            'created' => $this->created
        ];
    }
}
