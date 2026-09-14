<?php

declare(strict_types=1);

namespace Patterns\Proxy\Document;

use Closure;
use LogicException;
use Override;

final class SecureDocumentProviderProxy implements DocumentProvider
{
    private readonly Closure $providerFactory;

    private ?DocumentProvider $provider = null;

    public function __construct(
        callable $providerFactory,
        private readonly DocumentPermissionChecker $permissionChecker,
        private readonly User $currentUser
    ) {
        $this->providerFactory = Closure::fromCallable(
            $providerFactory
        );
    }

    #[Override]
    public function download(int $documentId): Document
    {
        if (!$this->permissionChecker->canDownload(
            $this->currentUser,
            $documentId
        )) {
            throw UnauthorizedDocumentAccess::forDocument(
                userId: $this->currentUser->id,
                documentId: $documentId
            );
        }

        return $this->provider()->download($documentId);
    }

    private function provider(): DocumentProvider
    {
        if ($this->provider !== null) {
            return $this->provider;
        }

        $provider = ($this->providerFactory)();

        if (!$provider instanceof DocumentProvider) {
            throw new LogicException(
                'The provider factory must return a DocumentProvider.',
            );
        }

        $this->provider = $provider;

        return $this->provider;
    }
}
