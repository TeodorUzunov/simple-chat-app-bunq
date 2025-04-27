<?php

namespace App\Infrastructure\Persistence\Message;

use App\Domain\Message\Message;
use App\Domain\Message\MessageRepository;
use PDO;

class SQLiteMessageRepository implements MessageRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addMessage(int $userId, int $chatGroupId, string $content): Message
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO Message (userID, chatGroupID, content, created)
            VALUES (:userID, :chatGroupID, :content, :created)
        ");

        $created = time();
        $message = [
            'userID' => $userId,
            'chatGroupID' => $chatGroupId,
            'content' => $content,
            'created' => $created,
        ];

        $stmt->execute($message);

        $id = (int)$this->pdo->lastInsertId();
        $message['ID'] = $id;

        return MessageMapper::map($message);
    }

    public function getAllMessagesForGroupIdSince(int $chatGroupId, int $since = 0): array
    {
        $stmt = $this->pdo->query(
            'SELECT * FROM Message WHERE chatGroupID = :id AND created >= :since ORDER BY created DESC'
        );
        $stmt->execute([
            'id' => $chatGroupId,
            'since' => $since
        ]);
        return MessageMapper::mapAll($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
