<?php

namespace Tests\Infrastructure\Persistence\ChatGroup;

use Tests\BaseTestCase;

class ChatGroupTest extends BaseTestCase
{
    public function testViewChatGroup(): void
    {
        $response = $this->jsonRequest('GET', '/api/chat_groups/1', [
            'id' => 1,
            'name' => 'test_group_1',
            'created' => 1745490297
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
