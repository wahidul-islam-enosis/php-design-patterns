<?php

declare(strict_types=1);

namespace Patterns\Template\Webhook;

use Override;

final class InMemoryProcessedWebhookStore implements ProcessedWebhookStore
{
    private array $processedEventIds = [];

    #[Override]
    public function has(string $eventId): bool
    {
        return isset($this->processedEventIds[$eventId]);
    }

    #[Override]
    public function markProcessed(string $eventId): void
    {
        $this->processedEventIds[$eventId] = true;
    }
}
