<?php

declare(strict_types=1);

namespace Patterns\Facade\Checkout\Exception;

use DomainException;

final class PaymentFailed extends DomainException {}
