<?php

declare(strict_types=1);

namespace Tests\Domain\ChatGroup;

use App\Domain\ChatGroup\ChatGroup;
use Tests\TestCase;

class ChatGroupTest extends TestCase
{
    public function chatGroupProvider(): array
    {
        return [
            [1, 'test_group_1', 1745490297],
            [2, 'test group 2', 1745480297],
            [3, 'test_group_3$', 1735490297],
        ];
    }

    /**
     * @dataProvider chatGroupProvider
     * @param int $id
     * @param string $name
     * @param int $created
     */
    public function testGetters(int $id, string $name, int $created)
    {
        $chatGroup = new ChatGroup($id, $name, $created);

        $this->assertEquals($id, $chatGroup->getId());
        $this->assertEquals($name, $chatGroup->getName());
        $this->assertEquals($created, $chatGroup->getCreated());
    }

    /**
     * @dataProvider chatGroupProvider
     * @param int $id
     * @param string $name
     * @param int $created
     */
    public function testJsonSerialize(int $id, string $name, int $created)
    {
        $chatGroup = new ChatGroup($id, $name, $created);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'created' => $created
        ]);

        $this->assertEquals($expectedPayload, json_encode($chatGroup));
    }
}
