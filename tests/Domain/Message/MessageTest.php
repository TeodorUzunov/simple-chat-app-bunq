<?php

declare(strict_types=1);

namespace Tests\Domain\Message;

use App\Domain\Message\Message;
use Tests\TestCase;

class MessageTest extends TestCase
{
    public function messageProvider(): array
    {
        return [
            [1, 1, 1, 'Test message from user 1 to chat group 1', 1745490297],
            [2, 1, 2, 'Test message from user 2 to chat group 1', 1745490297],
            [3, 3, 3, 'Test message from user 3 to chat group 3', 1745490297],
        ];
    }

    /**
     * @dataProvider messageProvider
     * @param int $id
     * @param int $chatGroupId
     * @param int $userId
     * @param string $content
     * @param int $created
     */
    public function testGetters(int $id, int $chatGroupId, int $userId, string $content, int $created)
    {
        $message = new Message($id, $chatGroupId, $userId, $content, $created);

        $this->assertEquals($id, $message->getId());
        $this->assertEquals($chatGroupId, $message->getChatGroupId());
        $this->assertEquals($userId, $message->getUserId());
        $this->assertEquals($content, $message->getContent());
        $this->assertEquals($created, $message->getCreated());
    }

    /**
     * @dataProvider messageProvider
     * @param int $id
     * @param int $chatGroupId
     * @param int $userId
     * @param string $content
     * @param int $created
     */
    public function testJsonSerialize(int $id, int $chatGroupId, int $userId, string $content, int $created)
    {
        $message = new Message($id, $chatGroupId, $userId, $content, $created);

        $expectedPayload = json_encode([
            'id' => $id,
            'chatGroupId' => $chatGroupId,
            'userId' => $userId,
            'content' => $content,
            'created' => $created
        ]);

        $this->assertEquals($expectedPayload, json_encode($message));
    }
}
