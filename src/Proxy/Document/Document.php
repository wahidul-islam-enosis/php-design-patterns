<?php

declare(strict_types=1);

namespace Patterns\Proxy\Document;

final readonly class Document
{
    public function __construct(
        public int $id,
        public int $ownerId,
        public string $filename,
        public string $content
    ) {}
}
