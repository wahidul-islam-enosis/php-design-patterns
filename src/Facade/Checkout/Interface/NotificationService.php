<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout\Interface;

interface NotificationService
{
    public function sendOrderConfirmation(
        int $customerId,
        int $orderId,
    ): void;
}
