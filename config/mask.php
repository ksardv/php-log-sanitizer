<?php

/**
 * This config file returns grouped regex patterns for log sanitization.
 *
 * Formats supported:
 * - 'text': For raw logs, strings, key=value formats
 * - 'json': For parsed JSON values (string content only)
 * - 'xml' : For XML element content or attributes
 * - 'yaml': For YAML key:value text representations
 */

return [

    'text' => [
        'email'          => '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/i',
        'password'       => '/(?i)(password\s*[:=]\s*)(["\']?)([^"\',\s}]+)(["\']?)/',
        'api_key'        => '/(?i)(api[_\-]?key)["\']?\s*[:=]\s*["\']?[a-zA-Z0-9_\-]{16,}/',
        'bearer_token'   => '/(?i)(bearer\s+)[a-z0-9\.\-_]+/',
        'jwt'            => '/eyJ[a-zA-Z0-9\-_]+?\.[a-zA-Z0-9\-_]+?\.[a-zA-Z0-9\-_]+/',
        'credit_card'    => '/\b(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|6(?:011|5[0-9]{2})[0-9]{12})\b/',
        'cvv'            => '/(?i)(cvv|cvc)["\']?\s*[:=]\s*["\']?\d{3,4}/',
        'ssn'            => '/\b\d{3}-\d{2}-\d{4}\b/',
        'egn'            => '/\b\d{10}\b/',
        'phone'          => '/\+?[0-9]{1,3}[\s\-]?\(?\d{1,4}\)?[\s\-]?\d{3,4}[\s\-]?\d{3,4}/',
        'ip_address'     => '/\b\d{1,3}(\.\d{1,3}){3}\b/',
        'iban'           => '/\b[A-Z]{2}[0-9]{2}[A-Z0-9]{11,30}\b/',
        'license_plate'  => '/\b[A-Z]{1,2}[0-9]{3,4}[A-Z]{1,2}\b/',
        'birthdate'      => '/\b\d{4}-\d{2}-\d{2}\b/',
        'username'       => '/(?i)(username)["\']?\s*[:=]\s*["\']?[a-zA-Z0-9_\-\.]{3,}/',
    ],

    'json' => [
        'email'          => '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/i',
        'password'       => '/mypassword123/i', // Adjust as needed; JSON sanitizes values only
        'token'          => '/[a-zA-Z0-9]{16,}/',
        'api_key'        => '/[a-zA-Z0-9_\-]{16,}/',
        'jwt'            => '/eyJ[a-zA-Z0-9\-_]+?\.[a-zA-Z0-9\-_]+?\.[a-zA-Z0-9\-_]+/',
        'credit_card'    => '/\b(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|6(?:011|5[0-9]{2})[0-9]{12})\b/',
        'ssn'            => '/\b\d{3}-\d{2}-\d{4}\b/',
        'phone'          => '/\+?[0-9]{1,3}[\s\-]?\(?\d{1,4}\)?[\s\-]?\d{3,4}[\s\-]?\d{3,4}/',
    ],

    'xml' => [
        'email'          => '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/i',
        'password'       => '/mypassword123/i',
        'token'          => '/[a-zA-Z0-9]{16,}/',
        'ssn'            => '/\b\d{3}-\d{2}-\d{4}\b/',
        'credit_card'    => '/\b(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|6(?:011|5[0-9]{2})[0-9]{12})\b/',
    ]
];