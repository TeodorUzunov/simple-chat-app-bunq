<?php

declare(strict_types=1);

namespace Tests\Domain\ChatGroupMember;

use App\Domain\ChatGroupMember\ChatGroupMember;
use Tests\TestCase;

class ChatGroupMemberTest extends TestCase
{
    public function chatGroupMemberProvider(): array
    {
        return [
            [1, 1, 1745490297],
            [2, 2, 1745480297],
            [3, 2, 1735490297],
        ];
    }

    /**
     * @dataProvider chatGroupMemberProvider
     * @param int $chatGroupId
     * @param int $userId
     * @param int $created
     */
    public function testGetters(int $chatGroupId, int $userId, int $created)
    {
        $chatGroupMember = new ChatGroupMember($chatGroupId, $userId, $created);

        $this->assertEquals($chatGroupId, $chatGroupMember->getChatGroupId());
        $this->assertEquals($userId, $chatGroupMember->getUserId());
        $this->assertEquals($created, $chatGroupMember->getCreated());
    }

    /**
     * @dataProvider chatGroupMemberProvider
     * @param int $chatGroupId
     * @param int $userId
     * @param int $created
     */
    public function testJsonSerialize(int $chatGroupId, int $userId, int $created)
    {
        $chatGroupMember = new ChatGroupMember($chatGroupId, $userId, $created);

        $expectedPayload = json_encode([
            'chatGroupId' => $chatGroupId,
            'userId' => $userId,
            'created' => $created
        ]);

        $this->assertEquals($expectedPayload, json_encode($chatGroupMember));
    }
}
