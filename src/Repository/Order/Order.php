<?php

declare(strict_types=1);

namespace Patterns\Repository\Order;

final readonly class Order
{
    public function __construct(
        public ?int $id,
        public int $customerId,
        public int $totalInCents,
        public OrderStatus $status
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getTotalInCents(): int
    {
        return $this->totalInCents;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }
}
