<?php

declare(strict_types=1);

namespace App\Domain\ChatGroup;

interface ChatGroupRepository
{
    /**
     * @return ChatGroup[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return ChatGroup|null
     */
    public function findChatGroupById(int $id): ?ChatGroup;

    /**
     * @param string $name
     * @return ChatGroup|null
     */
    public function findChatGroupByName(string $name): ?ChatGroup;

    /**
     * @param string $name
     * @param int $created
     * @return ChatGroup|null
     */
    public function addChatGroup(string $name, int $created): ?ChatGroup;
}
