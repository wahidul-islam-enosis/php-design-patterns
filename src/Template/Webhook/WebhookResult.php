<?php

declare(strict_types=1);

namespace Patterns\Template\Webhook;

final readonly class WebhookResult
{
    public function __construct(
        public WebhookStatus $status,
        public ?string $eventId = null
    ) {}

    public static function processed(string $eventId): self
    {
        return new self(
            status: WebhookStatus::Processed,
            eventId: $eventId
        );
    }

    public static function duplicate(string $eventId): self
    {
        return new self(
            status: WebhookStatus::Duplicate,
            eventId: $eventId
        );
    }

    public static function invalidSignature(): self
    {
        return new self(
            status: WebhookStatus::InvalidSignature
        );
    }
}
