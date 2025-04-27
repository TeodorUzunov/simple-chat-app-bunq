<?php

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserRepository;
use PDO;

class SQLiteUserRepository implements UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM User');
        return UserMapper::mapAll($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findUserById(int $id): ?User
    {
        $stmt = $this->pdo->query('SELECT * FROM User WHERE ID = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? UserMapper::map($user) : null;
    }
}
