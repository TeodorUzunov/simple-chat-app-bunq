<?php

namespace App\Infrastructure\Persistence\Message;

use App\Domain\Message\Message;

class MessageMapper
{
    public static function map(array $row): Message
    {
        return new Message(
            (int) $row['ID'],
            (int) $row['chatGroupID'],
            (int) $row['userID'],
            $row['content'],
            (int) $row['created']
        );
    }

    public static function mapAll(array $rows): array
    {
        return array_map([self::class, 'map'], $rows);
    }
}
