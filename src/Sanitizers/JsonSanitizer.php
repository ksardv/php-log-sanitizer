<?php

namespace Ksardv\PhpLogSanitizer\Sanitizers;

use Ksardv\PhpLogSanitizer\Contracts\Sanitizer;
use Ksardv\PhpLogSanitizer\Patterns\PatternRepository;

class JsonSanitizer implements Sanitizer
{
    public function __construct(private PatternRepository $patterns) {}

    public function sanitize(string $json): string
    {
        $data = json_decode($json, true);
        if ($data === null) {
            throw new \InvalidArgumentException('Invalid JSON format');
        }

        foreach ($this->patterns->getGroup('json') as $name => $pattern) {
            array_walk_recursive($data, function (&$value) use ($pattern) {
                if (is_string($value) && preg_match($pattern, $value)) {
                    $value = '***';
                }
            });
        }

        return json_encode($data);
    }
}
