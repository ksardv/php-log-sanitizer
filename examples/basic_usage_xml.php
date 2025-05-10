<?php

use Ksardv\PhpLogSanitizer\Sanitizers\XmlSanitizer;
use Ksardv\PhpLogSanitizer\Patterns\PatternRepository;

$patterns = PatternRepository::fromFile(__DIR__ . '/config/mask.php');

// Create the sanitizer instance for XML
$xmlSanitizer = new XmlSanitizer($patterns);

// Sample log in XML format
$log = <<<XML
<log>
    <user_email>test@example.com</user_email>
    <api_key>1234567890abcdef</api_key>
    <transaction_id>TXN1234567890</transaction_id>
</log>
XML;

// Sanitize the XML log
echo $xmlSanitizer->sanitize($log);
// Output will have 'user_email' and 'api_key' masked in the XML structure:
// <log>
//     <user_email>***</user_email>
//     <api_key>***</api_key>
//     <transaction_id>TXN1234567890</transaction_id>
// </log>