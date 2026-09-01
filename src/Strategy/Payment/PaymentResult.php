<?php

declare(strict_types=1);

namespace Patterns\Strategy\Payment;

final class PaymentResult
{
    public function __construct(
        public string $method,
        public int $amount,
        public string $message
    ) {}
}
