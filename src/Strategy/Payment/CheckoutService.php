<?php

declare(strict_types=1);

namespace Patterns\Strategy\Payment;

use InvalidArgumentException;

final readonly class CheckoutService
{
    public function __construct(
        private PaymentMethod $paymentMethod
    ) {}

    public function checkout(int $amount): PaymentResult
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException(
                'Payment amount must be greater than zero.'
            );
        }

        return $this->paymentMethod->pay($amount);
    }
}
