<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Message;

use Tests\BaseTestCase;

class ListMessagesForChatGroupActionTest extends BaseTestCase
{
    public function testListMessagesForChatGroup(): void
    {
        $response = $this->jsonRequest('GET', '/api/messages/1?userId=1&since=0');

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string)$response->getBody();
        $payload = json_decode($body, true);

        $this->assertIsArray($payload['data']);
        $this->assertCount(2, $payload['data']);

        $this->assertEquals('Test message from user 1 to chat group 1', $payload['data'][0]['content']);
        $this->assertEquals('Test message from user 2 to chat group 1', $payload['data'][1]['content']);
    }

    public function testListMessagesSinceTimestamp(): void
    {
        // Use a future timestamp to get no messages
        $futureTimestamp = time() + 10000;

        $response = $this->jsonRequest('GET', '/api/messages/1?userId=1&since=' . $futureTimestamp);

        $this->assertEquals(200, $response->getStatusCode());

        $payload = json_decode((string)$response->getBody(), true);

        $this->assertIsArray($payload['data']);
        $this->assertEmpty($payload['data']);
    }
}
