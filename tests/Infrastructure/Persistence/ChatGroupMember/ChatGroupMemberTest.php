<?php

namespace Tests\Infrastructure\Persistence\ChatGroupMember;

use Tests\BaseTestCase;

class ChatGroupMemberTest extends BaseTestCase
{
    public function testViewChatGroupMember(): void
    {
        $response = $this->jsonRequest('GET', '/api/chat_groups/1', [
            'id' => 1,
            'name' => 'test_group_1',
            'created' => 1745490297
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
