<?php

declare(strict_types=1);

namespace App\Domain\ChatGroupMember;

interface ChatGroupMemberRepository
{
    /**
     * @param int $userId
     * @return ChatGroupMember[]
     */
    public function findChatGroupsForUserId(int $userId): array;

    /**
     * @param int $userId
     * @param int $chatGroupId
     * @param int $created
     * @return ChatGroupMember
     */
    public function addUserToChatGroup(int $userId, int $chatGroupId, int $created = 0): ChatGroupMember;
}
