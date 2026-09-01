<?php

declare(strict_types=1);

namespace Patterns\Observer\Registration;

use Override;

final readonly class AuditLogObserver implements UserRegisteredObserver
{
    #[Override]
    public function handle(UserRegistered $event): void
    {
        print("Audit log has been saved for " . $event->userId . "\n");
    }
}
