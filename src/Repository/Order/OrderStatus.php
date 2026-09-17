<?php

declare(strict_types=1);

namespace Patterns\Repository\Order;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancelled = 'cancelled';
}
