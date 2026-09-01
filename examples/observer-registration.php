<?php

declare(strict_types=1);

use Patterns\Observer\Registration\AnalyticsObserver;
use Patterns\Observer\Registration\AuditLogObserver;
use Patterns\Observer\Registration\UserRegistrationService;
use Patterns\Observer\Registration\WelcomeEmailObserver;

require_once __DIR__ . '/../vendor/autoload.php';

$registrationService = new UserRegistrationService();
$welcomeObserver = new WelcomeEmailObserver();
$auditLogObserver = new AuditLogObserver();
$analyticsObserver = new AnalyticsObserver();

$registrationService->attach($welcomeObserver);
$registrationService->attach($auditLogObserver);
$registrationService->attach($analyticsObserver);
$registrationService->attach($welcomeObserver);

$registrationService->register(
    name: "Leon",
    email: "leontalukdar@gmail.com"
);

$registrationService->detach($analyticsObserver);

$registrationService->register(
    name: "Wahidul",
    email: "wahidul.islam@enosisbd.com"
);
