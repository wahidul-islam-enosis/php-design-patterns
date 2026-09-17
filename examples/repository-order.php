<?php

declare(strict_types=1);

use Patterns\Repository\Order\CancelOrderService;
use Patterns\Repository\Order\Exception\OrderCannotBeCancelled;
use Patterns\Repository\Order\Exception\OrderNotFound;
use Patterns\Repository\Order\InMemoryOrderRepository;
use Patterns\Repository\Order\Order;
use Patterns\Repository\Order\OrderStatus;

require_once __DIR__ . '/../vendor/autoload.php';

$orders = new InMemoryOrderRepository();
$cancelOrder = new CancelOrderService($orders);

// Save returns a new immutable order with an assigned ID.
$pending = $orders->save(new Order(
    id: null,
    customerId: 10,
    totalInCents: 2500,
    status: OrderStatus::Pending,
));

$paid = $orders->save(new Order(
    id: null,
    customerId: 10,
    totalInCents: 5000,
    status: OrderStatus::Paid,
));

$otherCustomerOrder = $orders->save(new Order(
    id: null,
    customerId: 20,
    totalInCents: 1500,
    status: OrderStatus::Pending,
));

echo 'Created orders:' . PHP_EOL;
foreach ([$pending, $paid, $otherCustomerOrder] as $order) {
    displayOrder($order);
}

// Cancellation updates the stored order without changing its ID or other data.
echo PHP_EOL . 'Cancel the pending order:' . PHP_EOL;
$cancelled = $cancelOrder->cancel($pending->getId());
displayOrder($cancelled);
echo "Original object status: {$pending->getStatus()->value}" . PHP_EOL;
echo 'Saved order:' . PHP_EOL;
displayOrder($orders->findById($cancelled->getId()));

echo PHP_EOL . 'Orders for customer 10:' . PHP_EOL;
foreach ($orders->findByCustomerId(10) as $order) {
    displayOrder($order);
}

// Expected failures are caught so the remaining examples can run.
foreach ([
    'Cancel a paid order' => $paid->getId(),
    'Cancel an already-cancelled order' => $cancelled->getId(),
    'Cancel a missing order' => 999,
] as $action => $orderId) {
    echo PHP_EOL . $action . ':' . PHP_EOL;

    try {
        $cancelOrder->cancel($orderId);
    } catch (OrderNotFound | OrderCannotBeCancelled $exception) {
        echo $exception::class . ': ' . $exception->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . 'Remove the order for customer 20:' . PHP_EOL;
$orders->remove($otherCustomerOrder);
echo 'Lookup after removal: ';
var_export($orders->findById($otherCustomerOrder->getId()));
echo PHP_EOL;

// Removing an unknown or unsaved order is harmless.
$orders->remove($otherCustomerOrder);
$orders->remove(new Order(null, 20, 1500, OrderStatus::Pending));
echo 'Removing unknown and unsaved orders completed.' . PHP_EOL;

echo PHP_EOL . 'The next new order still receives ID 4:' . PHP_EOL;
displayOrder($orders->save(new Order(null, 10, 3000, OrderStatus::Pending)));

function displayOrder(Order $order): void
{
    echo "Order #{$order->getId()} | Customer: {$order->getCustomerId()}"
        . " | Total: {$order->getTotalInCents()} cents"
        . " | Status: {$order->getStatus()->value}" . PHP_EOL;
}
