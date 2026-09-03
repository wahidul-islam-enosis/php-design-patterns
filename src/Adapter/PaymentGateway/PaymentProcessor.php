<?php

declare(strict_types=1);

namespace Patterns\Adapter\PaymentGateway;

interface PaymentProcessor
{
    public function charge(int $amountInCents, string $currency): PaymentResult;
}
