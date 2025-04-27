<?php

namespace Tests\Infrastructure\Persistence\User;

use Tests\BaseTestCase;

class UserTest extends BaseTestCase
{
    public function testViewUser(): void
    {
        $response = $this->jsonRequest('GET', '/api/users/1', [
            'id' => 1,
            'name' => 'test_user_1',
            'created' => 1745490297
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}