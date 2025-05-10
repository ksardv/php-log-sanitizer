<?php

namespace Ksardv\PhpLogSanitizer;

use Ksardv\PhpLogSanitizer\Contracts\Sanitizer;
use Ksardv\PhpLogSanitizer\Sanitizers\TextSanitizer;
use Ksardv\PhpLogSanitizer\Sanitizers\JsonSanitizer;
use Ksardv\PhpLogSanitizer\Sanitizers\XmlSanitizer;
use Ksardv\PhpLogSanitizer\Patterns\PatternRepository;

class LogSanitizer
{
    /**
     * @var array<string, Sanitizer>
     */
    protected array $handlers = [];

    /**
     * @var PatternRepository
     */
    protected PatternRepository $patterns;

    /**
     * Constructor
     */
    public function __construct(PatternRepository $patterns)
    {
        $this->patterns = $patterns;

        $this->handlers = [
            'text' => new TextSanitizer($this->patterns),
            'json' => new JsonSanitizer($this->patterns),
            'xml'  => new XmlSanitizer($this->patterns),
        ];
    }

    /**
     * Sanitize input based on format (text, json, xml)
     *
     * @param string $input
     * @param string $format
     * @return string
     */
    public function sanitize(string $input, string $format = 'text'): string
    {
        $handler = $this->handlers[$format] ?? $this->handlers['text'];
        return $handler->sanitize($input);
    }

    /**
     * Override or register a new handler
     *
     * @param string $format
     * @param Sanitizer $handler
     * @return void
     */
    public function setHandler(string $format, Sanitizer $handler): void
    {
        $this->handlers[$format] = $handler;
    }
}
