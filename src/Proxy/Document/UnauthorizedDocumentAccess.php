<?php

declare(strict_types=1);

namespace Patterns\Proxy\Document;

use RuntimeException;

final class UnauthorizedDocumentAccess extends RuntimeException
{
    public static function forDocument(
        int $userId,
        int $documentId
    ): self {
        return new self(
            "User {$userId} cannot download document {$documentId}."
        );
    }
}
