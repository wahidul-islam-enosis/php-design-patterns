<?php

declare(strict_types=1);

namespace Tests\Strategy\Payment;

use Generator;
use Patterns\Strategy\Payment\BkashPayment;
use Patterns\Strategy\Payment\CardPayment;
use Patterns\Strategy\Payment\CashOnDelivery;
use Patterns\Strategy\Payment\PaymentMethod;
use Patterns\Strategy\Payment\PaymentResult;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PaymentMethodTest extends TestCase
{
    private const int PAYMENT_AMOUNT = 3000;

    #[DataProvider('paymentMethodProvider')]
    public function test_it_processes_payment_using_the_selected_method(
        PaymentMethod $paymentMethod,
        PaymentResult $expectedResult
    ): void {
        $actualResult = $paymentMethod->pay(self::PAYMENT_AMOUNT);

        self::assertEquals($expectedResult, $actualResult);
    }

    public static function paymentMethodProvider(): Generator
    {
        yield 'card payment' => [
            new CardPayment(),
            new PaymentResult(
                method: 'card',
                amount: self::PAYMENT_AMOUNT,
                message: 'Card payment completed'
            )
        ];

        yield 'bKash payment' => [
            new BkashPayment(),
            new PaymentResult(
                method: 'bKash',
                amount: self::PAYMENT_AMOUNT,
                message: 'bKash payment completed'
            )
        ];

        yield 'cash on delivery' => [
            new CashOnDelivery(),
            new PaymentResult(
                method: 'cod',
                amount: self::PAYMENT_AMOUNT,
                message: 'Cash will be collected on delivery'
            )
        ];
    }
}
