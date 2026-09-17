<?php

declare(strict_types=1);

namespace Tests\Repository\Order;

use Patterns\Repository\Order\{CancelOrderService, InMemoryOrderRepository, Order, OrderRepository, OrderStatus};
use Patterns\Repository\Order\Exception\{OrderCannotBeCancelled, OrderNotFound};
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CancelOrderServiceTest extends TestCase
{
    public function test_missing_order_throws_without_saving(): void
    {
        $repository = $this->createMock(OrderRepository::class);
        $repository->expects(self::once())->method('findById')->with(99)->willReturn(null);
        $repository->expects(self::never())->method('save');
        $this->expectException(OrderNotFound::class);
        (new CancelOrderService($repository))->cancel(99);
    }

    public function test_pending_order_is_copied_and_saved_with_only_status_changed(): void
    {
        $original = new Order(7, 42, 12500, OrderStatus::Pending);
        $repository = $this->createMock(OrderRepository::class);
        $repository->expects(self::once())->method('findById')->with(7)->willReturn($original);
        $repository->expects(self::once())->method('save')->with(self::callback(
            static fn(Order $order): bool => $order !== $original
                && $order->getId() === 7
                && $order->getCustomerId() === 42
                && $order->getTotalInCents() === 12500
                && $order->getStatus() === OrderStatus::Cancelled
        ))->willReturnArgument(0);
        $cancelled = (new CancelOrderService($repository))->cancel(7);
        self::assertSame(OrderStatus::Cancelled, $cancelled->getStatus());
        self::assertSame(OrderStatus::Pending, $original->getStatus());
    }

    public static function nonPendingStatuses(): iterable
    {
        yield 'paid' => [OrderStatus::Paid];
        yield 'cancelled' => [OrderStatus::Cancelled];
    }

    #[DataProvider('nonPendingStatuses')]
    public function test_non_pending_orders_cannot_be_cancelled(OrderStatus $status): void
    {
        $repository = $this->createMock(OrderRepository::class);
        $repository->expects(self::once())->method('findById')->with(7)
            ->willReturn(new Order(7, 42, 12500, $status));
        $repository->expects(self::never())->method('save');
        $this->expectException(OrderCannotBeCancelled::class);
        (new CancelOrderService($repository))->cancel(7);
    }

    public function test_cancellation_is_persisted_and_cannot_be_repeated(): void
    {
        $repository = new InMemoryOrderRepository();
        $order = $repository->save(new Order(null, 42, 12500, OrderStatus::Pending));
        $service = new CancelOrderService($repository);
        $cancelled = $service->cancel($order->getId());
        self::assertSame($cancelled, $repository->findById($order->getId()));
        self::assertSame([$cancelled], $repository->findByCustomerId(42));
        $this->expectException(OrderCannotBeCancelled::class);
        $service->cancel($order->getId());
    }
}
