<?php

use Ksardv\PhpLogSanitizer\Patterns\PatternRepository;

// Load existing patterns from a config file
$patterns = PatternRepository::fromFile(__DIR__ . '/config/mask.php');

// Add a custom pattern for XML logs
$patterns->addPattern('bank_account', '/\b[A-Z]{2}\d{2}[A-Z0-9]{11,30}\b/', 'xml');

// Add a custom pattern for JSON logs
$patterns->addPattern('access_token', '/[a-f0-9]{32}/i', 'json');

// Add a pattern for text logs
$patterns->addPattern('secret_env', '/SECRET_KEY=[a-zA-Z0-9]+/', 'text');