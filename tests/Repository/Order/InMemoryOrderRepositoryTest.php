<?php

declare(strict_types=1);

namespace Tests\Repository\Order;

use Patterns\Repository\Order\{InMemoryOrderRepository, Order, OrderStatus};
use PHPUnit\Framework\TestCase;

final class InMemoryOrderRepositoryTest extends TestCase
{
    public function test_new_orders_receive_incremental_ids_and_updates_keep_their_id(): void
    {
        $repository = new InMemoryOrderRepository();
        $original = new Order(null, 10, 2500, OrderStatus::Pending);
        $first = $repository->save($original);
        self::assertNull($original->getId());
        self::assertSame(1, $first->getId());
        $updated = $repository->save(new Order($first->getId(), 10, 2500, OrderStatus::Paid));
        self::assertSame(1, $updated->getId());
        self::assertSame($updated, $repository->findById(1));
        self::assertSame(2, $repository->save($original)->getId());
        self::assertNull($repository->findById(999));
    }

    public function test_customer_lookup_returns_only_matching_orders_as_a_list(): void
    {
        $repository = new InMemoryOrderRepository();
        $repository->save(new Order(null, 20, 100, OrderStatus::Pending));
        $first = $repository->save(new Order(null, 10, 200, OrderStatus::Pending));
        $second = $repository->save(new Order(null, 10, 300, OrderStatus::Paid));
        self::assertSame([$first, $second], $repository->findByCustomerId(10));
        self::assertSame([], $repository->findByCustomerId(999));
    }

    public function test_removal_is_safe_and_does_not_reuse_ids(): void
    {
        $repository = new InMemoryOrderRepository();
        $order = $repository->save(new Order(null, 10, 100, OrderStatus::Pending));
        $other = $repository->save(new Order(null, 10, 200, OrderStatus::Pending));
        $repository->remove(new Order(null, 10, 100, OrderStatus::Pending));
        $repository->remove(new Order(999, 10, 100, OrderStatus::Pending));
        self::assertSame($order, $repository->findById(1));
        $repository->remove($order);
        $repository->remove($order);
        self::assertNull($repository->findById(1));
        self::assertSame([$other], $repository->findByCustomerId(10));
        self::assertSame(3, $repository->save(new Order(null, 10, 300, OrderStatus::Pending))->getId());
    }

    public function test_explicit_ids_do_not_collide_with_generated_ids(): void
    {
        $repository = new InMemoryOrderRepository();
        $existing = $repository->save(new Order(5, 10, 100, OrderStatus::Pending));
        self::assertSame(6, $repository->save(new Order(null, 10, 200, OrderStatus::Pending))->getId());
        self::assertSame($existing, $repository->findById(5));
    }
}
