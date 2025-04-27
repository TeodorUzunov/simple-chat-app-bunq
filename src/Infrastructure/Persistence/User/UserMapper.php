<?php

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;

class UserMapper
{
    public static function map(array $row): User
    {
        return new User((int) $row['ID'], $row['name'], (int)$row['created']);
    }

    public static function mapAll(array $rows): array
    {
        return array_map([self::class, 'map'], $rows);
    }
}
