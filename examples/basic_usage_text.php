<?php

require 'vendor/autoload.php';

use Ksardv\PhpLogSanitizer\Sanitizers\TextSanitizer;
use Ksardv\PhpLogSanitizer\Patterns\PatternRepository;

// Load the patterns from config
$patterns = PatternRepository::fromFile(__DIR__ . '/config/mask.php');

// Create the sanitizer instance
$sanitizer = new TextSanitizer($patterns);

// Sample log
$log = 'email: test@example.com, token: abc1234567890, internal_id=12345';

echo $sanitizer->sanitize($log); // Will mask email and token