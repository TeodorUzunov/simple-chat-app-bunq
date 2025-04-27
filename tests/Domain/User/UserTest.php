<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function userProvider(): array
    {
        return [
            [1, 'test_user_1', 1745490297],
            [2, 'test user 2', 1745480297],
            [3, 'test_user_3$', 1735490297],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param int $id
     * @param string $name
     * @param int $created
     */
    public function testGetters(int $id, string $name, int $created)
    {
        $user = new User($id, $name, $created);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($created, $user->getCreated());
    }

    /**
     * @dataProvider userProvider
     * @param int $id
     * @param string $name
     * @param int $created
     */
    public function testJsonSerialize(int $id, string $name, int $created)
    {
        $user = new User($id, $name, $created);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'created' => $created
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}
