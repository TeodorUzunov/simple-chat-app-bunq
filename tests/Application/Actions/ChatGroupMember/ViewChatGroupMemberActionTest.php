<?php

declare(strict_types=1);

namespace Tests\Application\Actions\ChatGroupMember;

use Tests\BaseTestCase;

class ViewChatGroupMemberActionTest extends BaseTestCase
{
    public function testViewChatGroupMemberAction(): void
    {
        $userId = 1;

        $response = $this->jsonRequest('GET', '/api/user_group_members/' . $userId);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);

        $this->assertIsArray($data['data']);
        $this->assertNotEmpty($data['data']);

        // Check if each membership has chatGroupId and the provided userId
        foreach ($data['data'] as $membership) {
            $this->assertArrayHasKey('chatGroupId', $membership);
            $this->assertEquals($userId, $membership['userId']); // make sure that no other user IDs are returned
        }
    }

    public function testViewChatGroupMemberActionWithNonExistentUser(): void
    {
        $userId = 9999; // use an ID that does not exist in the DB

        $response = $this->jsonRequest('GET', '/api/user_group_members/' . $userId);

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true)['data'];

        $this->assertArrayHasKey('message', $data);
        $this->assertEquals("User with ID {$userId} does not exist or has no memberships.", $data['message']);
    }
}
