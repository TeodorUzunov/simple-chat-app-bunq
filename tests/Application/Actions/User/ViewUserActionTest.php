<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use Tests\BaseTestCase;

class ViewUserActionTest extends BaseTestCase
{
    public function testViewUserSuccessfully(): void
    {
        $userId = 1;

        $response = $this->jsonRequest('GET', "/api/users/{$userId}");

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertEquals($userId, $data['data']['id']);
        $this->assertArrayHasKey('name', $data['data']);
        $this->assertArrayHasKey('created', $data['data']);
    }

    public function testViewChatGroupNotFound(): void
    {
        $userId = 999; // An ID that doesn't exist in the test DB

        $response = $this->jsonRequest('GET', "/api/users/{$userId}");

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('message', $data['data']);
        $this->assertEquals("User with ID {$userId} not found", $data['data']['message']);
    }
}
