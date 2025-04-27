<?php

declare(strict_types=1);

namespace Tests\Application\Actions\ChatGroup;

use Tests\BaseTestCase;

class AddChatGroupActionTest extends BaseTestCase
{
    public function testAddChatGroupSuccessfully(): void
    {
        $userId = 1;
        $name = 'new_test_group';
        $created = 1745502000;

        $response = $this->jsonRequest('POST', '/api/chat_groups', [
            'userId' => $userId,
            'name' => $name,
            'created' => $created
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('id', $data['data']);
        $this->assertEquals($name, $data['data']['name']);
    }

    public function testAddChatGroupWithMissingFields(): void
    {
        $created = 1745502000;

        $response = $this->jsonRequest('POST', '/api/chat_groups', [
            // Missing userId and name
            'created' => $created
        ]);

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('message', $data['data']);
        $this->assertEquals('Missing or invalid required parameters: userId or name', $data['data']['message']);
    }

    public function testAddChatGroupWithInvalidUser(): void
    {
        $userId = 999; // Invalid user ID (does not exist in the DB)
        $name = 'another_test_group';
        $created = 1745502000;

        $response = $this->jsonRequest('POST', '/api/chat_groups', [
            'userId' => $userId,
            'name' => $name,
            'created' => $created
        ]);

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('message', $data['data']);
        $this->assertEquals("User with ID {$userId} does not exist", $data['data']['message']);
    }

    public function testAddChatGroupWithExistingChatGroupName(): void
    {
        $userId = 1;
        $name = 'test_group_1'; // Invalid chat group name (does exist in the DB already)
        $created = 1745502000;

        $response = $this->jsonRequest('POST', '/api/chat_groups', [
            'userId' => $userId,
            'name' => $name,
            'created' => $created
        ]);

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('message', $data['data']);
        $this->assertEquals("Chat group with name '{$name}' already exists.", $data['data']['message']);
    }

    public function testAddChatGroupWithWhitespaceName(): void
    {
        $response = $this->jsonRequest('POST', '/api/chat_groups', [
            'userId' => 1,
            'name' => '   ',
            'created' => 1745502000
        ]);

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);
        $this->assertArrayHasKey('message', $data['data']);
        $this->assertEquals('Missing or invalid required parameters: userId or name', $data['data']['message']);
    }
}
