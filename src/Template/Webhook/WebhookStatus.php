<?php

declare(strict_types=1);

namespace Patterns\Template\Webhook;

enum WebhookStatus: string
{
    case Processed = 'processed';
    case Duplicate = 'duplicate';
    case InvalidSignature = 'invalid_signature';
}
