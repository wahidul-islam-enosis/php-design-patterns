<?php

declare(strict_types=1);

use Patterns\Decorator\Subscription\AdditionalUserDecorator;
use Patterns\Decorator\Subscription\BasicSubscription;
use Patterns\Decorator\Subscription\DiscountDecorator;
use Patterns\Decorator\Subscription\PrioritySupportDecorator;
use Patterns\Decorator\Subscription\TaxDecorator;

require_once __DIR__ . '/../vendor/autoload.php';

$subscription = new TaxDecorator(
    new DiscountDecorator(
        new PrioritySupportDecorator(
            new AdditionalUserDecorator(
                new BasicSubscription(),
                additionalUser: 3,
            ),
        ),
        10,
    ),
);

echo $subscription->description() . PHP_EOL;
echo "Total: " . $subscription->priceInCents() . PHP_EOL;
