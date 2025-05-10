<?php

require 'vendor/autoload.php';

use Ksardv\PhpLogSanitizer\Sanitizers\JsonSanitizer;
use Ksardv\PhpLogSanitizer\Patterns\PatternRepository;

// Load the patterns from config
$patterns = PatternRepository::fromFile(__DIR__ . '/config/mask.php');

// Create the sanitizer instance for JSON
$jsonSanitizer = new JsonSanitizer($patterns);

// Sample log in JSON format
$log = json_encode([
    'user_email' => 'test@example.com',
    'api_key' => '1234567890abcdef',
    'transaction_id' => 'TXN1234567890'
]);

echo $jsonSanitizer->sanitize($log); 
// Output will have 'user_email' and 'api_key' masked, something like:
// {"user_email":"***","api_key":"***","transaction_id":"TXN1234567890"}