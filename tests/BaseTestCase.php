<?php

declare(strict_types=1);

namespace Tests;

use DI\ContainerBuilder;
use PDO;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\StreamFactory;

abstract class BaseTestCase extends TestCase
{
    protected App $app;

    protected function setUp(): void
    {
        parent::setUp();

        $containerBuilder = new ContainerBuilder();

        // Load all configuration into the builder
        (require __DIR__ . '/../app/settings.php')($containerBuilder);
        (require __DIR__ . '/../app/dependencies.php')($containerBuilder);
        (require __DIR__ . '/../app/repositories.php')($containerBuilder);


        // Set up the PDO connection for testing
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Load the test database schema
        $schema = file_get_contents(__DIR__ . '/schema.sql');
        $this->pdo->exec($schema);

        $container = $containerBuilder->build();

        // Pass the PDO connection into the container so it can be used by the application
        $container->set(PDO::class, $this->pdo);

        AppFactory::setContainer($container);
        $this->app = AppFactory::create();

        (require __DIR__ . '/../app/routes.php')($this->app);
    }

    protected function createRequest(string $method, string $path): \Psr\Http\Message\ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $path);
    }

    protected function createStream(string $content): \Psr\Http\Message\StreamInterface
    {
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $content);
        rewind($stream);
        return (new StreamFactory())->createStream($content);
    }

    protected function jsonRequest(string $method, string $path, array $data = []): \Psr\Http\Message\ResponseInterface
    {
        $request = $this->createRequest($method, $path)
            ->withHeader('Content-Type', 'application/json')
            ->withParsedBody($data);

        return $this->app->handle($request);
    }
}
