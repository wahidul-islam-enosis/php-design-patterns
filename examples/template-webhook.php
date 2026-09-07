<?php

declare(strict_types=1);

use Patterns\Template\Webhook\CardPaymentWebhookHandler;
use Patterns\Template\Webhook\ConsolePaymentEventProcessor;
use Patterns\Template\Webhook\InMemoryProcessedWebhookStore;
use Patterns\Template\Webhook\WalletPaymentWebhookHandler;
use Patterns\Template\Webhook\WebhookResult;

require_once __DIR__ . '/../vendor/autoload.php';

function displayResult(WebhookResult $result)
{
    echo 'Status: ' . $result->status->value . PHP_EOL;
    echo 'Event ID: ' . ($result->eventId ?? 'N/A') . PHP_EOL;
    echo PHP_EOL;
}

$processor = new ConsolePaymentEventProcessor();
$store = new InMemoryProcessedWebhookStore();

echo "=== Card payment webhook ===" . PHP_EOL;

$cardSecret = 'card-webhook-secret';

$cardHandler = new CardPaymentWebhookHandler(
    processWebhookStore: $store,
    paymenteventProcessor: $processor,
    secret: $cardSecret
);

$cardPayload = json_encode([
    'id' => 'card-event-1001',
    'type' => 'payment.completed',
    'data' => [
        'order_id' => 501,
        'amount_in_cents' => 10_000,
        'currency' => 'USD',
    ],
], JSON_THROW_ON_ERROR);

$cardSignature = hash_hmac(
    algo: 'sha256',
    data: $cardPayload,
    key: $cardSecret,
);

$cardResult = $cardHandler->handle(
    payload: $cardPayload,
    signature: $cardSignature,
);

displayResult($cardResult);

echo "=== Wallet payment webhook ===" . PHP_EOL;

$walletSecret = 'wallet-webhook-secret';

$walletHandler = new WalletPaymentWebhookHandler(
    processWebhookStore: $store,
    paymenteventProcessor: $processor,
    secret: $walletSecret,
);

$walletPayload = json_encode([
    'meta' => [
        'event_id' => 'wallet-event-2001',
    ],
    'event_name' => 'wallet.payment.completed',
    'data' => [
        'order_id' => 502,
        'amount_in_cents' => 7_500,
        'currency' => 'USD',
    ],
], JSON_THROW_ON_ERROR);

$walletBinaryHash = hash_hmac(
    algo: 'sha256',
    data: $walletPayload,
    key: $walletSecret,
    binary: true,
);

$walletSignature = base64_encode($walletBinaryHash);

$walletResult = $walletHandler->handle(
    payload: $walletPayload,
    signature: $walletSignature,
);

displayResult($walletResult);

echo "=== Duplicate card webhook ===" . PHP_EOL;

$duplicateResult = $cardHandler->handle(
    payload: $cardPayload,
    signature: $cardSignature,
);

displayResult($duplicateResult);
