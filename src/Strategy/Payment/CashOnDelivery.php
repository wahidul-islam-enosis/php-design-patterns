<?php

declare(strict_types=1);

namespace Patterns\Strategy\Payment;

use Override;

final class CashOnDelivery implements PaymentMethod
{
    #[Override]
    public function pay(int $amount): PaymentResult
    {
        return new PaymentResult(
            method: 'cod',
            amount: $amount,
            message: "Cash will be collected on delivery"
        );
    }
}
