<?php

declare(strict_types=1);

namespace Patterns\Proxy\Document;

final readonly class User
{
    public function __construct(
        public int $id,
        public string $role
    ) {}
}
