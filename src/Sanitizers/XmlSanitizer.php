<?php

namespace Ksardv\PhpLogSanitizer\Sanitizers;

use Ksardv\PhpLogSanitizer\Contracts\Sanitizer;
use Ksardv\PhpLogSanitizer\Patterns\PatternRepository;
use SimpleXMLElement;

class XmlSanitizer implements Sanitizer
{
    public function __construct(private PatternRepository $patterns) {}

    public function sanitize(string $xml): string
    {
        $doc = simplexml_load_string($xml);
        if ($doc === false) {
            throw new \InvalidArgumentException('Invalid XML format');
        }

        $this->sanitizeNode($doc, $this->patterns->getGroup('xml'));

        return $doc->asXML();
    }

    private function sanitizeNode(SimpleXMLElement $node, array $patterns): void
    {
        foreach ($node->children() as $child) {
            $this->sanitizeNode($child, $patterns); // Recurse into children
        }

        $nodeName = strtolower($node->getName());
        $nodeValue = (string) $node;

        foreach ($patterns as $key => $pattern) {
            // 1. Sanitize value by regex match (regardless of tag name)
            if (preg_match($pattern, $nodeValue)) {
                $node[0] = '***';
                break;
            }

            // 2. Sanitize based on tag name match
            if ($nodeName === strtolower($key)) {
                $node[0] = '***';
                break;
            }
        }
    }
}
