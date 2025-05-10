<?php

namespace Ksardv\PhpLogSanitizer\Sanitizers;

use Ksardv\PhpLogSanitizer\Contracts\Sanitizer;
use Ksardv\PhpLogSanitizer\Patterns\PatternRepository;

class TextSanitizer implements Sanitizer
{
    const REPLACEMENT = '$1$2***$4';

    public function __construct(private PatternRepository $patterns) {}

    public function sanitize(string $input): string
    {
        foreach ($this->patterns->getGroup('text') as $name => $pattern) {
            $input = preg_replace($pattern, self::REPLACEMENT, $input);
        }

        return $input;
    }
}
