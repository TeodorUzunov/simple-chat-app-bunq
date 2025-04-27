<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Message;

use Tests\BaseTestCase;

class AddMessageActionTest extends BaseTestCase
{
    public function testAddMessageToChatGroup(): void
    {
        $payload = [
            'userId' => 5,
            'content' => 'This is a test message added via test suite.',
        ];

        $response = $this->jsonRequest('POST', '/api/messages/6', $payload);

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string)$response->getBody();
        $data = json_decode($body, true);

        $this->assertIsArray($data['data']);
        $this->assertArrayHasKey('id', $data['data']);
        $this->assertEquals(6, $data['data']['chatGroupId']);
        $this->assertEquals(5, $data['data']['userId']);
        $this->assertEquals('This is a test message added via test suite.', $data['data']['content']);
    }

    public function testAddMessageWithMissingContent(): void
    {
        $payload = [
            'userId' => 1,
            // No 'content'
        ];

        $response = $this->jsonRequest('POST', '/api/messages/1', $payload);

        $this->assertEquals(200, $response->getStatusCode()); // Adjust if you throw errors for missing data

        $data = json_decode((string)$response->getBody(), true);
        $this->assertNotEmpty($data['data']['id'] ?? '');
        $this->assertEquals('', $data['data']['content']); // Because trim('') from empty default
    }
}
