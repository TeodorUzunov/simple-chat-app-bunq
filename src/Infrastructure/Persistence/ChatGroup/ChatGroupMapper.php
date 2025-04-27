<?php

namespace App\Infrastructure\Persistence\ChatGroup;

use App\Domain\ChatGroup\ChatGroup;

class ChatGroupMapper
{
    public static function map(array $row): ChatGroup
    {
        return new ChatGroup(
            (int) $row['ID'],
            $row['name'],
            (int) $row['created']
        );
    }

    public static function mapAll(array $rows): array
    {
        return array_map([self::class, 'map'], $rows);
    }
}
