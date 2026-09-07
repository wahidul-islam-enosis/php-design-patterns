<?php

declare(strict_types=1);

namespace Patterns\Template\Webhook;

interface PaymentEventProcessor
{
    public function process(array $event): void;
}
