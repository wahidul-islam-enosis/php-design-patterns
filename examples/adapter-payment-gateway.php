<?php

declare(strict_types=1);

use Patterns\Adapter\PaymentGateway\LegacyPaymentAdapter;
use Patterns\Adapter\PaymentGateway\LegacyPaymentGateway;

require_once __DIR__ . '/../vendor/autoload.php';


$payentProcessor = new LegacyPaymentAdapter(
    new LegacyPaymentGateway()
);

$result = $payentProcessor->charge(120, 'usd');

$formatted = array_map(function ($val) {
    return is_bool($val) ? (int) $val : $val;
}, $result->toArray());

print_r($formatted);
