<?php

declare(strict_types=1);

namespace Tests\Template\Webhook;

use Override;
use Patterns\Template\Webhook\CardPaymentWebhookHandler;
use Patterns\Template\Webhook\InMemoryProcessedWebhookStore;
use Patterns\Template\Webhook\PaymentEventProcessor;
use Patterns\Template\Webhook\WalletPaymentWebhookHandler;
use Patterns\Template\Webhook\WebhookStatus;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class WebhookHandlerTest extends TestCase
{
    private const string SECRET = 'test-webhook-secret';

    private InMemoryProcessedWebhookStore $store;

    private PaymentEventProcessor&MockObject $processor;

    private CardPaymentWebhookHandler $cardHandler;

    private WalletPaymentWebhookHandler $walletHandler;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->store = new InMemoryProcessedWebhookStore();

        $this->processor = $this->createMock(
            PaymentEventProcessor::class
        );

        $this->cardHandler = new CardPaymentWebhookHandler(
            processWebhookStore: $this->store,
            paymenteventProcessor: $this->processor,
            secret: self::SECRET
        );

        $this->walletHandler = new WalletPaymentWebhookHandler(
            processWebhookStore: $this->store,
            paymenteventProcessor: $this->processor,
            secret: self::SECRET,
        );
    }

    public function test_valid_card_event_is_processed_and_recorded(): void
    {
        $payload = json_encode([
            'id' => 'card-event-101',
            'type' => 'payment.completed',
            'amount' => 10_000
        ]);

        $this->processor
            ->expects(self::once())
            ->method('process')
            ->with(self::callback(
                static fn(array $event): bool =>
                $event['id'] = 'card-event-101'
                    && $event['type'] === 'payment.completed'
            ));

        $signature = $this->createCardSignature($payload);

        $result = $this->cardHandler->handle($payload, $signature);

        self::assertSame(WebhookStatus::Processed, $result->status);
        self::assertSame('card-event-101', $result->eventId);
        self::assertTrue($this->store->has('card-event-101'));
    }

    public function test_invalid_signature_stops_processing_immediately(): void
    {
        $this->processor
            ->expects(self::never())
            ->method('process');

        /*
         * Invalid JSON proves that decoding is not attempted when
         * signature verification fails.
         */
        $result = $this->cardHandler->handle(
            payload: 'invalid JSON',
            signature: 'invalid-signature',
        );

        self::assertSame(
            WebhookStatus::InvalidSignature,
            $result->status,
        );

        self::assertNull($result->eventId);
    }

    public function test_duplicate_event_is_not_processed_again(): void
    {
        $this->store->markProcessed('card-event-101');

        $payload = json_encode([
            'id' => 'card-event-101',
            'type' => 'payment.completed',
        ], JSON_THROW_ON_ERROR);

        $this->processor
            ->expects(self::never())
            ->method('process');

        $result = $this->cardHandler->handle(
            payload: $payload,
            signature: $this->createCardSignature($payload),
        );

        self::assertSame(WebhookStatus::Duplicate, $result->status);
        self::assertSame('card-event-101', $result->eventId);
    }

    public function test_failed_processing_does_not_mark_event_as_processed(): void
    {
        $payload = json_encode([
            'id' => 'card-event-failed',
            'type' => 'payment.failed',
        ], JSON_THROW_ON_ERROR);

        $this->processor
            ->expects(self::once())
            ->method('process')
            ->willThrowException(
                new RuntimeException('Payment processing failed.'),
            );

        try {
            $this->cardHandler->handle(
                payload: $payload,
                signature: $this->createCardSignature($payload),
            );

            self::fail('Expected RuntimeException was not thrown.');
        } catch (RuntimeException $exception) {
            self::assertSame(
                'Payment processing failed.',
                $exception->getMessage(),
            );
        }

        self::assertFalse($this->store->has('card-event-failed'));
    }

    public function test_wallet_handler_uses_its_own_signature_algorithm(): void
    {
        $payload = json_encode([
            'meta' => [
                'event_id' => 'wallet-event-2001',
            ],
            'event_name' => 'wallet.payment.completed',
            'data' => [
                'amount' => 5_000,
            ],
        ], JSON_THROW_ON_ERROR);

        $this->processor
            ->expects(self::once())
            ->method('process');

        $result = $this->walletHandler->handle(
            payload: $payload,
            signature: $this->createWalletSignature($payload),
        );

        self::assertSame(WebhookStatus::Processed, $result->status);
        self::assertSame('wallet-event-2001', $result->eventId);
        self::assertTrue($this->store->has('wallet-event-2001'));
    }

    public function test_card_signature_is_not_valid_for_wallet_handler(): void
    {
        $payload = json_encode([
            'meta' => [
                'event_id' => 'wallet-event-2002',
            ],
        ], JSON_THROW_ON_ERROR);

        $this->processor
            ->expects(self::never())
            ->method('process');

        $result = $this->walletHandler->handle(
            payload: $payload,
            signature: $this->createCardSignature($payload),
        );

        self::assertSame(
            WebhookStatus::InvalidSignature,
            $result->status,
        );

        self::assertFalse($this->store->has('wallet-event-2002'));
    }

    private function createCardSignature(string $payload): string
    {
        return hash_hmac(
            algo: 'sha256',
            data: $payload,
            key: self::SECRET,
        );
    }

    private function createWalletSignature(string $payload): string
    {
        $binaryHash = hash_hmac(
            algo: 'sha256',
            data: $payload,
            key: self::SECRET,
            binary: true,
        );

        return base64_encode($binaryHash);
    }
}
