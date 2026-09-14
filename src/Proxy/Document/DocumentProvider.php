<?php

declare(strict_types=1);

namespace Patterns\Proxy\Document;

interface DocumentProvider
{
    public function download(int $documentId): Document;
}
