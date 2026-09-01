<?php

declare(strict_types=1);

use Patterns\Strategy\Payment\BkashPayment;
use Patterns\Strategy\Payment\CardPayment;
use Patterns\Strategy\Payment\CashOnDelivery;
use Patterns\Strategy\Payment\CheckoutService;

require_once __DIR__ . '/../vendor/autoload.php';

$paymentMethods = [
    new CardPayment(),
    new BkashPayment(),
    new CashOnDelivery()
];

foreach ($paymentMethods as $paymentMethod) {
    $checkout = new CheckoutService($paymentMethod);
    $result = $checkout->checkout(2500);

    echo sprintf(
        "Method: %s | Amount: %d | Message: %s%s",
        $result->method,
        $result->amount,
        $result->message,
        PHP_EOL
    );
}
