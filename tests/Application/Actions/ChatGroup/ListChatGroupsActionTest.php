<?php

declare(strict_types=1);

namespace Tests\Application\Actions\ChatGroup;

use Tests\BaseTestCase;

class ListChatGroupsActionTest extends BaseTestCase
{
    public function testListChatGroupsSuccessfully(): void
    {
        $response = $this->jsonRequest('GET', '/api/chat_groups');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertIsArray($data['data']);
        $this->assertGreaterThan(0, count($data['data']));

        foreach ($data['data'] as $group) {
            $this->assertArrayHasKey('id', $group);
            $this->assertArrayHasKey('name', $group);
            $this->assertArrayHasKey('created', $group);
        }
    }

    public function testListChatGroupsWhenEmpty(): void
    {
        // Clear all chat groups from the database
        $this->pdo->exec('DELETE FROM ChatGroup WHERE 1');

        $response = $this->jsonRequest('GET', '/api/chat_groups');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string)$response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertIsArray($data['data']);
        $this->assertCount(0, $data['data']);
    }
}
