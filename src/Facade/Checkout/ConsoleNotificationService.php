<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout;

use Override;
use Patterns\Facade\Checkout\Interface\NotificationService;

final readonly class ConsoleNotificationService implements NotificationService
{
    #[Override]
    public function sendOrderConfirmation(int $customerId, int $orderId): void
    {
        echo sprintf(
            'Order %d confirmation sent to customer %d.%s',
            $orderId,
            $customerId,
            PHP_EOL,
        );
    }
}
