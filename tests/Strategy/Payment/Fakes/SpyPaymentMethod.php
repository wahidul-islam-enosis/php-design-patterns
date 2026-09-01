<?php

declare(strict_types=1);

namespace Tests\Strategy\Payment\Fakes;

use Override;
use Patterns\Strategy\Payment\PaymentMethod;
use Patterns\Strategy\Payment\PaymentResult;

final class SpyPaymentMethod implements PaymentMethod
{
    public ?int $receivedAmount = null;

    #[Override]
    public function pay(int $amount): PaymentResult
    {
        $this->receivedAmount = $amount;

        return new PaymentResult(
            method: 'fake',
            amount: $amount,
            message: "Fake payment completed"
        );
    }
}
