<?php

declare(strict_types=1);

namespace Tests\Application\Actions\ChatGroupMember;

use Tests\BaseTestCase;

class AddUserToChatGroupActionTest extends BaseTestCase
{
    public function testAddUserToChatGroupAction(): void
    {
        $chatGroupId = 3;
        $userId = 1;
        $created = time();

        $response = $this->jsonRequest('POST', "/api/user_group_members/{$chatGroupId}", [
            'userId' => $userId,
            'created' => $created
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('chatGroupId', $data['data']);
        $this->assertArrayHasKey('userId', $data['data']);
        $this->assertEquals($chatGroupId, $data['data']['chatGroupId']);
        $this->assertEquals($userId, $data['data']['userId']);
        $this->assertEquals($created, $data['data']['created']);
    }

    public function testAddUserToChatGroupActionWithMissingParameters(): void
    {
        $chatGroupId = 1;

        //Perform a POST request with missing parameters
        $response = $this->jsonRequest('POST', "/api/user_group_members/{$chatGroupId}", []);

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('message', $data['data']);
        $this->assertEquals('Missing required parameters: userId or chatGroupId', $data['data']['message']);
    }

    public function testAddUserToChatGroupActionWithInvalidUserId(): void
    {
        $chatGroupId = 1;
        $invalidUserId = 999; // Invalid user ID (does not exist in the DB)
        $created = time();

        // Perform a POST request to add the invalid user to the chat group
        $response = $this->jsonRequest('POST', "/api/user_group_members/{$chatGroupId}", [
            'userId' => $invalidUserId,
            'created' => $created
        ]);

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertArrayHasKey('message', $data['data']);
        $this->assertEquals('User with ID 999 does not exist', $data['data']['message']);
    }
}
