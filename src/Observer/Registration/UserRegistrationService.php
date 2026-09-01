<?php

declare(strict_types=1);

namespace Patterns\Observer\Registration;

use SplObjectStorage;

final class UserRegistrationService
{
    private SplObjectStorage $observers;
    private $nextUserId = 1;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function attach(UserRegisteredObserver $observer)
    {
        $this->observers[$observer] = true;
    }

    public function detach(UserRegisteredObserver $observer)
    {
        unset($this->observers[$observer]);
    }

    public function register(string $name, string $email): UserRegistered
    {
        $event = new UserRegistered(
            userId: $this->nextUserId++,
            name: $name,
            email: $email
        );

        $this->notify($event);

        return $event;
    }

    private function notify(UserRegistered $event)
    {
        foreach ($this->observers as $observer) {
            $observer->handle($event);
        }
    }
}
