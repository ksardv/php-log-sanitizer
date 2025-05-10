<?php

namespace Ksardv\PhpLogSanitizer\Contracts;

interface Sanitizer
{
    public function sanitize(string $input): string;
}