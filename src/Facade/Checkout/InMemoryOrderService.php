<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout;

use Override;
use Patterns\Facade\Checkout\Dto\CheckoutItem;
use Patterns\Facade\Checkout\Interface\OrderService;

final class InMemoryOrderService implements OrderService
{
    private int $nextOrderId = 1;

    /**
     * @var array<int, array{
     *      customerId: int,
     *      items: list<CheckoutItem>,
     *      totalInCents: int,
     *      transactionId: string
     * }>
     */
    private array $orders = [];

    #[Override]
    public function create(int $customerId, array $items, int $totalInCents, string $transactionId): int
    {
        $orderId = $this->nextOrderId++;

        $this->orders[$orderId] = [
            'customerId' => $customerId,
            'items' => $items,
            'totalInCents' => $totalInCents,
            'transactionId' => $transactionId
        ];

        return $orderId;
    }

    /**
     * @return array<int, array{
     *      customerId: int,
     *      items: list<CheckoutItem>,
     *      totalInCents: int,
     *      transactionId: string
     * }>
     */
    public function find(int $orderId): ?array
    {
        return $this->orders[$orderId] ?? null;
    }
}
