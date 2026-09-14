<?php

declare(strict_types=1);

use Patterns\Proxy\Document\Document;
use Patterns\Proxy\Document\DocumentProvider;
use Patterns\Proxy\Document\InMemoryDocumentPermissionChecker;
use Patterns\Proxy\Document\RemoteDocumentProvider;
use Patterns\Proxy\Document\SecureDocumentProviderProxy;
use Patterns\Proxy\Document\User;

require_once __DIR__ . '/../vendor/autoload.php';

$documents = [
    101 => new Document(
        id: 101,
        ownerId: 10,
        filename: 'invoice-101.pdf',
        content: 'Private invoice content',
    ),
    102 => new Document(
        id: 102,
        ownerId: 20,
        filename: 'report-102.pdf',
        content: 'Private report content',
    ),
];


$permissionChecker = new InMemoryDocumentPermissionChecker([
    100 => 10,
    101 => 10,
    102 => 20,
]);

$currentUser = new User(
    id: 10,
    role: 'customer'
);

$documentProvider = new SecureDocumentProviderProxy(
    providerFactory: static function () use (
        $documents,
    ): DocumentProvider {
        return new RemoteDocumentProvider($documents);
    },
    permissionChecker: $permissionChecker,
    currentUser: $currentUser
);

echo "Proxy created." . PHP_EOL;

/*
 * The RemoteDocumentProvider has not been created yet.
 * It is created during the first authorized download.
 */
$document = $documentProvider->download(101);

echo "Downloaded: {$document->filename}" . PHP_EOL;
echo "Content: {$document->content}" . PHP_EOL;
