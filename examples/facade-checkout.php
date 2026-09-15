<?php

declare(strict_types=1);

use Patterns\Facade\Checkout\CatalogPricingSerice;
use Patterns\Facade\Checkout\CheckoutFacade;
use Patterns\Facade\Checkout\ConsoleNotificationService;
use Patterns\Facade\Checkout\Dto\CheckoutItem;
use Patterns\Facade\Checkout\Dto\CheckoutRequest;
use Patterns\Facade\Checkout\InMemoryInventoryService;
use Patterns\Facade\Checkout\InMemoryOrderService;
use Patterns\Facade\Checkout\InMemoryPaymentService;

require_once __DIR__ . '/../vendor/autoload.php';

$inventory = new InMemoryInventoryService([
    10 => 20,
    20 => 10
]);

$pricing = new CatalogPricingSerice(
    priceInCents: [
        10 => 1500,
        20 => 1000
    ],
    couponDiscounts: [
        'SAVE10' => 10
    ]
);

$payments = new InMemoryPaymentService();
$orders = new InMemoryOrderService();
$notifications = new ConsoleNotificationService();

$checkout = new CheckoutFacade(
    inventory: $inventory,
    pricing: $pricing,
    payment: $payments,
    order: $orders,
    notification: $notifications
);

$result = $checkout->checkout(
    new CheckoutRequest(
        customerId: 1,
        items: [
            new CheckoutItem(
                productId: 10,
                quantity: 2
            ),
            new CheckoutItem(
                productId: 20,
                quantity: 3
            )
        ],
        couponCode: 'save10',
        paymentToken: 'valid-payment'
    )
);

echo "Order ID: {$result->orderId}" . PHP_EOL;
echo "Transaction: {$result->transactionId}" . PHP_EOL;
echo "Charged: {$result->chargedAmount} cents" . PHP_EOL;

$result = $checkout->checkout(
    new CheckoutRequest(
        customerId: 2,
        items: [
            new CheckoutItem(
                productId: 10,
                quantity: 4
            ),
            new CheckoutItem(
                productId: 20,
                quantity: 2
            )
        ],
        couponCode: 'save10',
        paymentToken: 'valid-payment'
    )
);

echo "Order ID: {$result->orderId}" . PHP_EOL;
echo "Transaction: {$result->transactionId}" . PHP_EOL;
echo "Charged: {$result->chargedAmount} cents" . PHP_EOL;

// Thii will give InsufficientInventory exception
// $result = $checkout->checkout(
//     new CheckoutRequest(
//         customerId: 3,
//         items: [
//             new CheckoutItem(
//                 productId: 10,
//                 quantity: 100
//             ),
//             new CheckoutItem(
//                 productId: 20,
//                 quantity: 100
//             )
//         ],
//         couponCode: 'save10',
//         paymentToken: 'valid-payment'
//     )
// );

// echo "Order ID: {$result->orderId}" . PHP_EOL;
// echo "Transaction: {$result->transactionId}" . PHP_EOL;
// echo "Charged: {$result->chargedAmount} cents" . PHP_EOL;
