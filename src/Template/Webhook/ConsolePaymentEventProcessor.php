<?php

declare(strict_types=1);

namespace Patterns\Template\Webhook;

use Override;

final readonly class ConsolePaymentEventProcessor implements PaymentEventProcessor
{
    #[Override]
    public function process(array $event): void
    {
        $eventType = $event['type'] ?? $event['event_name'] ?? 'unknown';

        echo "Processing event: {$eventType}" . PHP_EOL;
    }
}
