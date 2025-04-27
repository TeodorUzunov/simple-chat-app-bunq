<?php

declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;

class User implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private int $created;

    public function __construct(?int $id, string $name, int $created)
    {
        $this->id = $id;
        $this->name = strtolower($name);
        $this->created = $created;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreated(): int
    {
        return $this->created;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created' => $this->created
        ];
    }
}
