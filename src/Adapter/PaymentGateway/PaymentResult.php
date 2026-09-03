<?php

declare(strict_types=1);

namespace Patterns\Adapter\PaymentGateway;

final readonly class PaymentResult
{
    public function __construct(
        public bool $successful,
        public ?string $transactionId,
        public ?string $failureReason
    ) {}

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
