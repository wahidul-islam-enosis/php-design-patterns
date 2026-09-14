<?php

declare(strict_types=1);

namespace Patterns\Proxy\Document;

use Override;

final class RemoteDocumentProvider implements DocumentProvider
{
    public function __construct(
        private readonly array $documents
    ) {}

    #[Override]
    public function download(int $documentId): Document
    {
        echo "Downloading document {$documentId} remotely." . PHP_EOL;

        return $this->documents[$documentId]
            ?? throw DocumentNotFound::withId($documentId);
    }
}
