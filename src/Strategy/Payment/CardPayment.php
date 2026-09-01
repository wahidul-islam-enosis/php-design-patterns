<?php

declare(strict_types=1);

namespace Patterns\Strategy\Payment;

use Override;

final class CardPayment implements PaymentMethod
{
    #[Override]
    public function pay(int $amount): PaymentResult
    {
        return new PaymentResult(
            method: 'card',
            amount: $amount,
            message: "Card payment completed"
        );
    }
}
