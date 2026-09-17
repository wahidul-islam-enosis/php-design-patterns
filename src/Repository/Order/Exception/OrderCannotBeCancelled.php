<?php

declare(strict_types=1);

namespace Patterns\Repository\Order\Exception;

use DomainException;

final class OrderCannotBeCancelled extends DomainException {}
