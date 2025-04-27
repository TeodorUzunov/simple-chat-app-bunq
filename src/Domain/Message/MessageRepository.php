<?php

declare(strict_types=1);

namespace App\Domain\Message;

interface MessageRepository
{
    /**
     * @param int $userId
     * @param int $chatGroupId
     * @param string $content
     * @return Message
     */
    public function addMessage(int $userId, int $chatGroupId, string $content): Message;
    public function getAllMessagesForGroupIdSince(int $chatGroupId, int $since = 0): array;
}
