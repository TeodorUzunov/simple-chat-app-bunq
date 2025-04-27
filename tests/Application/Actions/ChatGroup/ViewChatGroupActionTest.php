<?php

declare(strict_types=1);

namespace Tests\Application\Actions\ChatGroup;

use Tests\BaseTestCase;

class ViewChatGroupActionTest extends BaseTestCase
{
    public function testViewChatGroupSuccessfully(): void
    {
        $chatGroupId = 1;

        $response = $this->jsonRequest('GET', "/api/chat_groups/{$chatGroupId}");

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertEquals($chatGroupId, $data['data']['id']);
        $this->assertArrayHasKey('name', $data['data']);
        $this->assertArrayHasKey('created', $data['data']);
    }

    public function testViewChatGroupNotFound(): void
    {
        $chatGroupId = 999; // An ID that doesn't exist in the test DB

        $response = $this->jsonRequest('GET', "/api/chat_groups/{$chatGroupId}");

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('message', $data['data']);
        $this->assertEquals("Chat group with ID {$chatGroupId} not found", $data['data']['message']);
    }
}
