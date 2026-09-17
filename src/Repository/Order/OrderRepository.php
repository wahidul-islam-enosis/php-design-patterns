<?php

declare(strict_types=1);

namespace Patterns\Repository\Order;

interface OrderRepository
{
    public function findById(int $id): ?Order;

    /**
     * @return list<Order>
     */
    public function findByCustomerId(int $customerId): array;

    public function save(Order $order): Order;

    public function remove(Order $order): void;
}
