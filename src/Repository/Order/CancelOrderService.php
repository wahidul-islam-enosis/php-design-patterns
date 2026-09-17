<?php

declare(strict_types=1);

namespace Patterns\Repository\Order;

use Patterns\Repository\Order\Exception\OrderCannotBeCancelled;
use Patterns\Repository\Order\Exception\OrderNotFound;

final readonly class CancelOrderService
{
    public function __construct(private OrderRepository $orders) {}

    public function cancel(int $orderId): Order
    {
        $order = $this->orders->findById($orderId);

        if ($order === null) {
            throw new OrderNotFound("Order {$orderId} was not found.");
        }

        if ($order->getStatus() !== OrderStatus::Pending) {
            throw new OrderCannotBeCancelled("A {$order->getStatus()->value} order cannot be cancelled.");
        }

        return $this->orders->save(new Order(
            $order->getId(),
            $order->getCustomerId(),
            $order->getTotalInCents(),
            OrderStatus::Cancelled,
        ));
    }
}
