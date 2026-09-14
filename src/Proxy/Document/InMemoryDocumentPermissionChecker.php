<?php

declare(strict_types=1);

namespace Patterns\Proxy\Document;

use Override;

final readonly class InMemoryDocumentPermissionChecker implements DocumentPermissionChecker
{
    public function __construct(
        private array $docuentOwners,
    ) {}

    #[Override]
    public function canDownload(User $user, int $documentId): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        $ownerId = $this->docuentOwners[$documentId] ?? null;

        return $ownerId !== null && $ownerId === $user->id;
    }
}
