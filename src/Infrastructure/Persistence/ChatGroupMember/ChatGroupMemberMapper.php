<?php

namespace App\Infrastructure\Persistence\ChatGroupMember;

use App\Domain\ChatGroupMember\ChatGroupMember;

class ChatGroupMemberMapper
{
    public static function map(array $row): ChatGroupMember
    {
        return new ChatGroupMember(
            (int) $row['chatGroupID'],
            (int) $row['userID'],
            (int) $row['created']
        );
    }

    public static function mapAll(array $rows): array
    {
        return array_map([self::class, 'map'], $rows);
    }
}
