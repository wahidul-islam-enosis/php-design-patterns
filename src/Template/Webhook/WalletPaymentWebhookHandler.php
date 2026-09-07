<?php

declare(strict_types=1);

namespace Patterns\Template\Webhook;

use Override;
use UnexpectedValueException;

final class WalletPaymentWebhookHandler extends WebhookHandler
{
    public function __construct(
        ProcessedWebhookStore $processWebhookStore,
        private readonly PaymentEventProcessor $paymenteventProcessor,
        private readonly string $secret
    ) {
        parent::__construct($processWebhookStore);
    }

    #[Override]
    protected function verifySignature(string $payload, string $signature): bool
    {
        $binaryHash = hash_hmac(
            algo: 'sha256',
            data: $payload,
            key: $this->secret,
            binary: true
        );

        $expectedSignature = base64_encode($binaryHash);

        return hash_equals($expectedSignature, $signature);
    }

    #[Override]
    protected function decode(string $payload): array
    {
        $event = json_decode(
            json: $payload,
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );

        if (!is_array($event)) {
            throw new UnexpectedValueException(
                'The wallet webhook payload must contain JSON object'
            );
        }

        return $event;
    }

    #[Override]
    protected function extractEventId(array $event): string
    {
        $eventId = $event['meta']['event_id'] ?? null;

        if (!is_string($eventId) || $eventId === '') {
            throw new UnexpectedValueException(
                'The wallet webhook event ID is missing'
            );
        }

        return $eventId;
    }

    #[Override]
    protected function processEvent(array $event): void
    {
        $this->paymenteventProcessor->process($event);
    }
}
