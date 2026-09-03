<?php

declare(strict_types=1);

namespace Patterns\Adapter\PaymentGateway;

final class LegacyPaymentGateway
{
    /**
     * @return array{
     *     status: 'approved'|'declined',
     *     reference?: string,
     *     error?: string
     * }
     */
    public function makePayment(float $amount, string $currencyCode): array
    {
        if ($amount <= 0) {
            return [
                'status' => 'declined',
                'error' => 'Invalid amount',
            ];
        }

        return [
            'status' => 'approved',
            'reference' => 'LEGACY-12345',
        ];
    }
}
