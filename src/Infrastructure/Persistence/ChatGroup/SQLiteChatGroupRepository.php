<?php

namespace App\Infrastructure\Persistence\ChatGroup;

use App\Domain\ChatGroup\ChatGroup;
use App\Domain\ChatGroup\ChatGroupRepository;
use PDO;

class SQLiteChatGroupRepository implements ChatGroupRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM ChatGroup');
        return ChatGroupMapper::mapAll($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findChatGroupById(int $id): ?ChatGroup
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ChatGroup WHERE ID = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? ChatGroupMapper::map($result) : null;
    }

    public function findChatGroupByName(string $name): ?ChatGroup
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ChatGroup WHERE name = :name');
        $stmt->execute(['name' => $name]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? ChatGroupMapper::map($result) : null;
    }

    public function addChatGroup(string $name, int $created): ChatGroup
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO ChatGroup (name, created)
            VALUES (:name, :created)
        ");

        $created = $created ?: time();
        $chatGroup = [
            'name' => $name,
            'created' => $created,
        ];

        $stmt->execute($chatGroup);

        $chatGroup['ID'] = (int) $this->pdo->lastInsertId();

        return ChatGroupMapper::map($chatGroup);
    }

}
