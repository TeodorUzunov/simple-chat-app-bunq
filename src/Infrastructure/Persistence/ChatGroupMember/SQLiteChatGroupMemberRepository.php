<?php

namespace App\Infrastructure\Persistence\ChatGroupMember;

use App\Domain\ChatGroupMember\ChatGroupMember;
use App\Domain\ChatGroupMember\ChatGroupMemberRepository;
use PDO;

class SQLiteChatGroupMemberRepository implements ChatGroupMemberRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findChatGroupsForUserId(int $userId): array
    {
        $stmt = $this->pdo->query('SELECT * FROM ChatGroupMember WHERE userID = :id');
        $stmt->execute(['id' => $userId]);
        return ChatGroupMemberMapper::mapAll($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function addUserToChatGroup(int $userId, int $chatGroupId, int $created = 0): ChatGroupMember
    {

        $stmt = $this->pdo->prepare("
            INSERT INTO ChatGroupMember (userID, chatGroupID, created)
            VALUES (:userID, :chatGroupID, :created)
        ");

        $created = $created ?: time(); //set the current time if one is not provided
        $data = [
            'userID' => $userId,
            'chatGroupID' => $chatGroupId,
            'created' => $created,
        ];

        $stmt->execute($data);

        return ChatGroupMemberMapper::map($data);
    }
}
