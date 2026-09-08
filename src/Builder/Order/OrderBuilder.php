<?php

declare(strict_types=1);

namespace Patterns\Builder\Order;

use InvalidArgumentException;
use LogicException;

final class OrderBuilder
{
    private string $customerEmail = '';

    /** @var array<int, Item> */
    private array $items = [];

    private ?string $shippingAddress = '';

    private ?string $couponCode = '';

    private bool $giftWrapping = false;

    public function forCustomer(string $email): self
    {
        if (!is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException(
                'The email is invalid'
            );
        }

        $this->customerEmail = $email;
        return $this;
    }

    public function addItem(Item $item): self
    {
        $item->validate();

        $this->items[] = $item;

        return $this;
    }

    public function shippingAddress(string $address): self
    {
        $this->shippingAddress = $address;

        return $this;
    }

    public function coupon(string $couponCode): self
    {
        $this->couponCode = $couponCode;

        return $this;
    }

    public function withGiftWrapping(): self
    {
        $this->giftWrapping = true;

        return $this;
    }

    public function build(): Order
    {
        if ($this->customerEmail === '') {
            throw new LogicException(
                "Customer email is required."
            );
        }

        if (count($this->items) < 1) {
            throw new LogicException(
                "An order must contain at least one item."
            );
        }

        return new Order(
            customerEmail: $this->customerEmail,
            items: $this->items,
            shippingAddress: $this->shippingAddress,
            couponCode: $this->couponCode,
            giftWrapping: $this->giftWrapping
        );
    }
}
