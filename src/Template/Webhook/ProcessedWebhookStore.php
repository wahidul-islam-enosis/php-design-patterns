<?php

declare(strict_types=1);

namespace Patterns\Template\Webhook;

interface ProcessedWebhookStore
{
    public function has(string $eventId): bool;

    public function markProcessed(string $eventId): void;
}
