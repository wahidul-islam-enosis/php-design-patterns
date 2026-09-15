<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout;

use Override;
use Patterns\Facade\Checkout\Exception\PaymentFailed;
use Patterns\Facade\Checkout\Interface\PaymentService;

final class InMemoryPaymentService implements PaymentService
{
    private int $nextTransId = 1;

    #[Override]
    public function charge(string $paymentToken, int $amountInCents): string
    {
        if (trim($paymentToken) === '') {
            throw new PaymentFailed(
                'A payment token is required.',
            );
        }

        if ($amountInCents < 0) {
            throw new PaymentFailed(
                'The payment amount cannot be negative.',
            );
        }

        if ($paymentToken === 'declined-token') {
            throw new PaymentFailed(
                'The payment was declined.',
            );
        }

        return sprintf(
            'transaction-%d',
            $this->nextTransId++
        );
    }
}
