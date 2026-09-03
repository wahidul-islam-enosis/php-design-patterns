<?php

declare(strict_types=1);

namespace Patterns\Decorator\Subscription;

interface Subscription
{
    public function priceInCents(): int;

    public function description(): string;
}
