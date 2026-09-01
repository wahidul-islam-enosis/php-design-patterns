<?php

declare(strict_types=1);

namespace Patterns\Strategy\Payment;

interface PaymentMethod
{
    public function pay(int $amount): PaymentResult;
}
