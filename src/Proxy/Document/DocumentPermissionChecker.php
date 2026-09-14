<?php

declare(strict_types=1);

namespace Patterns\Proxy\Document;

interface DocumentPermissionChecker
{
    public function canDownload(
        User $user,
        int $documentId
    ): bool;
}
