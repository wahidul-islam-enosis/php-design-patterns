<?php

declare(strict_types=1);

namespace Patterns\Repository\Order;

use Override;

final class InMemoryOrderRepository implements OrderRepository
{
    /**
     * @var array<int, Order> $orders
     */
    private array $orders = [];

    private int $nextId = 1;

    #[Override]
    public function findById(int $id): ?Order
    {
        return $this->orders[$id] ?? null;
    }

    #[Override]
    public function save(Order $order): Order
    {
        if ($order->getId() === null) {
            $order = new Order(
                $this->nextId++,
                $order->getCustomerId(),
                $order->getTotalInCents(),
                $order->getStatus(),
            );
        }

        $this->nextId = max($this->nextId, $order->getId() + 1);
        $this->orders[$order->getId()] = $order;
        return $order;
    }

    #[Override]
    public function remove(Order $order): void
    {
        if ($order->getId() === null) {
            return;
        }

        unset($this->orders[$order->getId()]);
    }

    #[Override]
    public function findByCustomerId(int $customerId): array
    {
        return array_values(
            array_filter(
                $this->orders,
                fn(Order $order) => $order->getCustomerId() === $customerId
            )
        );
    }
}
