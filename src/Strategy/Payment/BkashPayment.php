<?php

declare(strict_types=1);

namespace Patterns\Strategy\Payment;

use Override;

final class BkashPayment implements PaymentMethod
{
    #[Override]
    public function pay(int $amount): PaymentResult
    {
        return new PaymentResult(
            method: 'bKash',
            amount: $amount,
            message: "bKash payment completed"
        );
    }
}
