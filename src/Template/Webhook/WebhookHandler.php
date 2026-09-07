<?php

declare(strict_types=1);

namespace Patterns\Template\Webhook;

abstract class WebhookHandler
{
    public function __construct(
        private readonly ProcessedWebhookStore $processWebhookStore
    ) {}

    final public function handle(string $payload, string $signature): WebhookResult
    {
        if (!$this->verifySignature($payload, $signature)) {
            return WebhookResult::invalidSignature();
        }

        $event = $this->decode($payload);
        $eventId = $this->extractEventId($event);

        if ($this->processWebhookStore->has($eventId)) {
            return WebhookResult::duplicate($eventId);
        }

        $this->beforeProcessing($event);
        $this->processEvent($event);
        $this->afterProcessing($event);

        $this->processWebhookStore->markProcessed($eventId);

        return WebhookResult::processed($eventId);
    }

    abstract protected function verifySignature(
        string $payload,
        string $signature
    ): bool;

    abstract protected function decode(string $payload): array;

    abstract protected function extractEventId(array $event): string;

    abstract protected function processEvent(array $event): void;

    protected function beforeProcessing(array $event): void {}

    protected function afterProcessing(array $event): void {}
}
