<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout\Interface;

interface PaymentService
{
    public function charge(
        string $paymentToken,
        int $amountInCents
    ): string;
}
