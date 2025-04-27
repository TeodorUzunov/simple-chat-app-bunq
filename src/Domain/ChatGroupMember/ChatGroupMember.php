<?php

declare(strict_types=1);

namespace App\Domain\ChatGroupMember;

use JsonSerializable;

class ChatGroupMember implements JsonSerializable
{
    private int $chatGroupId;

    private int $userId;

    private int $created;

    public function __construct(int $chatGroupId, int $userId, int $created)
    {
        $this->chatGroupId = $chatGroupId;
        $this->userId = $userId;
        $this->created = $created;
    }

    public function getChatGroupId(): int
    {
        return $this->chatGroupId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCreated(): int
    {
        return $this->created;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'chatGroupId' => $this->chatGroupId,
            'userId' => $this->userId,
            'created' => $this->created
        ];
    }
}
