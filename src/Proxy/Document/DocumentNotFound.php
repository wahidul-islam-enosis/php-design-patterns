<?php

declare(strict_types=1);

namespace Patterns\Proxy\Document;

use RuntimeException;

final class DocumentNotFound extends RuntimeException
{
    public static function withId(int $documentId): self
    {
        return new self(
            "Document {$documentId} was not found.",
        );
    }
}
