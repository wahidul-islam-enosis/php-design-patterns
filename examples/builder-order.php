<?php

declare(strict_types=1);

use Patterns\Builder\Order\Item;
use Patterns\Builder\Order\OrderBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

$order = (new OrderBuilder())
    ->forCustomer('wahidul@example.com')
    ->addItem(new Item(
        productId: 10,
        quantity: 2,
        unitPriceInCents: 1_500,
    ))
    ->addItem(new Item(
        productId: 20,
        quantity: 1,
        unitPriceInCents: 500,
    ))
    ->shippingAddress('Dhaka, Bangladesh')
    ->withGiftWrapping()
    ->build();

echo $order->subtotalInCents() . PHP_EOL;
