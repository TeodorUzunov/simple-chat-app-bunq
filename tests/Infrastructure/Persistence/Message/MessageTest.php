<?php

namespace Tests\Infrastructure\Persistence\Message;

use Tests\BaseTestCase;

class MessageTest extends BaseTestCase
{
    public function testViewMessage(): void
    {
        $response = $this->jsonRequest('GET', '/api/messages/1', [
            'id' => 1,
            'chatGroupId' => 1,
            'userId' => 1,
            'content' => 'Test message from user 1 to chat group 1',
            'created' => 1745490297
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
