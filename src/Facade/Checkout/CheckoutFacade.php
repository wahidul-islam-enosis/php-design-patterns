<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout;

use Patterns\Facade\Checkout\Dto\CheckoutRequest;
use Patterns\Facade\Checkout\Dto\CheckoutResult;
use Patterns\Facade\Checkout\Exception\InvalidCheckout;
use Patterns\Facade\Checkout\Interface\InventoryService;
use Patterns\Facade\Checkout\Interface\NotificationService;
use Patterns\Facade\Checkout\Interface\OrderService;
use Patterns\Facade\Checkout\Interface\PaymentService;
use Patterns\Facade\Checkout\Interface\PricingService;

final readonly class CheckoutFacade
{
    public function __construct(
        private InventoryService $inventory,
        private PricingService $pricing,
        private PaymentService $payment,
        private OrderService $order,
        private NotificationService $notification
    ) {}

    public function checkout(
        CheckoutRequest $request
    ): CheckoutResult {
        $this->validate($request);

        foreach ($request->items as $item) {
            $this->inventory->reserve(
                $item->productId,
                $item->quantity
            );
        }

        $total = $this->pricing->calculateTotal(
            $request->items,
            $request->couponCode
        );

        $transactionId = $this->payment->charge(
            $request->paymentToken,
            $total
        );

        $orderId = $this->order->create(
            $request->customerId,
            $request->items,
            $total,
            $transactionId
        );

        $this->notification->sendOrderConfirmation(
            $request->customerId,
            $orderId
        );

        return new CheckoutResult(
            orderId: $orderId,
            transactionId: $transactionId,
            chargedAmount: $total
        );
    }

    private function validate(CheckoutRequest $request): void
    {
        if ($request->customerId < 1) {
            throw new InvalidCheckout(
                'The customer ID must be positive.',
            );
        }

        if ($request->items === []) {
            throw new InvalidCheckout(
                'Checkout must contain at least one item.',
            );
        }

        if (trim($request->paymentToken) === '') {
            throw new InvalidCheckout(
                'A payment token is required.',
            );
        }

        foreach ($request->items as $item) {
            if ($item->productId < 1) {
                throw new InvalidCheckout(
                    'Product IDs must be positive.',
                );
            }

            if ($item->quantity < 1) {
                throw new InvalidCheckout(
                    'Item quantities must be positive.',
                );
            }
        }
    }
}
