<?php

namespace Ksardv\PhpLogSanitizer\Patterns;

class PatternRepository
{
    /**
     * @var array<string, array<string, string>> Patterns grouped by format (e.g., 'json', 'text')
     */
    protected array $groups = [];

    /**
     * Constructor
     *
     * @param array<string, array<string, string>|string> $patterns
     */
    public function __construct(array $patterns = [])
    {
        $this->setPatterns($patterns);
    }

    /**
     * Load patterns from a config file (e.g. mask.php)
     *
     * @param string $path
     * @return static
     */
    public static function fromFile(string $path): self
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException("Pattern config file not found: $path");
        }

        $patterns = require $path;

        if (!is_array($patterns)) {
            throw new \RuntimeException("Pattern config file must return an array");
        }

        return new self($patterns);
    }

    /**
     * Add a pattern to a specific format group (default: 'text')
     *
     * @param string $name
     * @param string $regex
     * @param string $group
     * @return void
     */
    public function addPattern(string $name, string $regex, string $group = 'text'): void
    {
        if (@preg_match($regex, '') === false) {
            throw new \InvalidArgumentException("Invalid regex for pattern '$name'");
        }

        $this->groups[$group][$name] = $regex;
    }

    /**
     * Remove a pattern from a format group
     *
     * @param string $name
     * @param string $group
     * @return void
     */
    public function removePattern(string $name, string $group = 'text'): void
    {
        unset($this->groups[$group][$name]);
    }

    /**
     * Get all patterns for a format group
     *
     * @param string $group
     * @return array<string, string>
     */
    public function getGroup(string $group): array
    {
        if (!isset($this->groups[$group])) {
            throw new \InvalidArgumentException("Pattern group not found: $group");
        }

        return $this->groups[$group];
    }

    /**
     * Get all groups
     *
     * @return array<string, array<string, string>>
     */
    public function getAllGroups(): array
    {
        return $this->groups;
    }

    /**
     * Set all patterns (accepts grouped or flat format)
     *
     * @param array<string, array<string, string>|string> $patterns
     * @return void
     */
    public function setPatterns(array $patterns): void
    {
        $this->groups = [];

        foreach ($patterns as $key => $value) {
            if (is_array($value)) {
                // Treat as group
                foreach ($value as $name => $regex) {
                    $this->addPattern($name, $regex, $key);
                }
            } elseif (is_string($value)) {
                // Flat structure fallback
                $this->addPattern($key, $value, 'text');
            }
        }
    }

    /**
     * Check if a pattern exists in a group
     *
     * @param string $name
     * @param string $group
     * @return bool
     */
    public function hasPattern(string $name, string $group = 'text'): bool
    {
        return isset($this->groups[$group][$name]);
    }
}
