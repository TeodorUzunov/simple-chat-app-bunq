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
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

putenv('APP_ENV=testing');

// ------------------
// Build the container
// ------------------

$containerBuilder = new ContainerBuilder();

// Register settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Register dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Register repositories (swap to SQLite repos for testing)
$containerBuilder->addDefinitions([
    PDO::class => function () {
        // You can use ':memory:' or 'tests/test.sqlite' for file-based testing
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Load schema (must exist)
        $schema = file_get_contents(__DIR__ . '/schema.sql');
        $pdo->exec($schema);

        return $pdo;
    },

    // Swap repository interfaces to real implementations
    UserRepository::class => \DI\autowire(SQLiteUserRepository::class),
    ChatGroupRepository::class => \DI\autowire(SQLiteChatGroupRepository::class),
    ChatGroupMemberRepository::class => \DI\autowire(SQLiteChatGroupMemberRepository::class),
    MessageRepository::class => \DI\autowire(SQLiteMessageRepository::class),
]);

$container = $containerBuilder->build();
AppFactory::setContainer($container);

// Create the app
$app = AppFactory::create();

// Register middleware and routes
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

// Store app instance globally for tests
$GLOBALS['app'] = $app;
