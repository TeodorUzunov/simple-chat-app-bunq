<?php

declare(strict_types=1);

use App\Domain\ChatGroup\ChatGroupRepository;
use App\Domain\ChatGroupMember\ChatGroupMemberRepository;
use App\Domain\Message\MessageRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\ChatGroup\SQLiteChatGroupRepository;
use App\Infrastructure\Persistence\ChatGroupMember\SQLiteChatGroupMemberRepository;
use App\Infrastructure\Persistence\Message\SQLiteMessageRepository;
use App\Infrastructure\Persistence\User\SQLiteUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(SQLiteUserRepository::class),
        ChatGroupRepository::class => \DI\autowire(SQLiteChatGroupRepository::class),
        ChatGroupMemberRepository::class => \DI\autowire(SQLiteChatGroupMemberRepository::class),
        MessageRepository::class => \DI\autowire(SQLiteMessageRepository::class),
    ]);
};
