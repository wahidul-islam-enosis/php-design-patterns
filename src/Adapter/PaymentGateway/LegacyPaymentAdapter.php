<?php

declare(strict_types=1);

namespace Patterns\Adapter\PaymentGateway;

use Override;

final class LegacyPaymentAdapter implements PaymentProcessor
{
    private LegacyPaymentGateway $legacyPayment;

    public function __construct(LegacyPaymentGateway $legacyPayment)
    {
        $this->legacyPayment = $legacyPayment;
    }

    #[Override]
    public function charge(int $amountInCents, string $currency): PaymentResult
    {
        $amount = $amountInCents / 100;
        $currencyCode = strtoupper($currency);

        $payment = $this->legacyPayment->makePayment($amount, $currencyCode);
        $result = match ($payment['status']) {
            'approved' => [
                'successful' => true,
                'trasactionId' => $payment['reference'],
                'failureReason' => null
            ],
            'declined' => [
                'successful' => false,
                'trasactionId' => null,
                'failureReason' => $payment['error']
            ],
        };

        return new PaymentResult(
            $result['successful'],
            $result['trasactionId'],
            $result['failureReason']
        );
    }
}
