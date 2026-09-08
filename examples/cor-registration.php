<?php

declare(strict_types=1);

use Patterns\COR\Registration\EmailFormatHandler;
use Patterns\COR\Registration\InMemoryUserRepository;
use Patterns\COR\Registration\PasswordStrengthHandler;
use Patterns\COR\Registration\RegistrationSuccessHandler;
use Patterns\COR\Registration\RequiredFieldHandler;
use Patterns\COR\Registration\UniqueEmailHandler;

require_once __DIR__ . '/../vendor/autoload.php';

$userRepository = new InMemoryUserRepository([
    'existing@example.com'
]);

$requiredFields = new RequiredFieldHandler();
$emailFormat = new EmailFormatHandler();
$passwordStrength = new PasswordStrengthHandler();
$uniqueEmail = new UniqueEmailHandler($userRepository);
$success = new RegistrationSuccessHandler();

$data = [
    'name' => 'Wahidul',
    'email' => 'wahidul@example.com',
    'password' => 'Secret123',
];

$requiredFields
    ->setNext($emailFormat)
    ->setNext($passwordStrength)
    ->setNext($uniqueEmail)
    ->setNext($success);

$result = $requiredFields->handle($data);

if ($result->valid) {
    echo 'Registration data is valid.' . PHP_EOL;
} else {
    echo "Validation failed: {$result->error}" . PHP_EOL;
}
