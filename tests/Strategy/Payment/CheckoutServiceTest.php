<?php

declare(strict_types=1);

namespace Tests\Strategy\Payment;

use InvalidArgumentException;
use Override;
use Patterns\Strategy\Payment\CheckoutService;
use PHPUnit\Framework\TestCase;
use Tests\Strategy\Payment\Fakes\SpyPaymentMethod;

final class CheckoutServiceTest extends TestCase
{
    private SpyPaymentMethod $paymentMethod;
    private CheckoutService $checkout;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentMethod = new SpyPaymentMethod();
        $this->checkout = new CheckoutService($this->paymentMethod);
    }

    public function test_it_delegates_payment_to_the_selected_strategy(): void
    {
        $result = $this->checkout->checkout(2500);

        self::assertSame(2500, $this->paymentMethod->receivedAmount);
        self::assertSame('fake', $result->method);
        self::assertSame(2500, $result->amount);
        self::assertSame('Fake payment completed', $result->message);
    }

    public function test_it_rejects_a_zero_amount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Payment amount must be greater than zero.'
        );
        $this->checkout->checkout(0);
    }

    public function test_it_rejects_a_negative_amount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Payment amount must be greater than zero.'
        );

        $this->checkout->checkout(-500);
    }
}
