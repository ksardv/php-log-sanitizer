<?php

use PHPUnit\Framework\TestCase;
use Ksardv\PhpLogSanitizer\LogSanitizer;
use Ksardv\PhpLogSanitizer\Patterns\PatternRepository;

class LogSanitizerTest extends TestCase
{
    protected LogSanitizer $sanitizer;

    protected function setUp(): void
    {
        $patterns = PatternRepository::fromFile(__DIR__ . '/../config/mask.php');
        $this->sanitizer = new LogSanitizer($patterns);
    }

    public function testTextSanitization()
    {
        $log = 'email: test@example.com, token: f4c1234567890, password: dasd%4asd)9^, internal_id=12345';
        $sanitized = $this->sanitizer->sanitize($log, 'text');

        $this->assertStringNotContainsString('john.doe@example.com', $sanitized);
        $this->assertStringNotContainsString('dasd%4asd)9^', $sanitized);
        $this->assertStringNotContainsString('f4c1234567890', $sanitized);
        $this->assertStringContainsString('***', $sanitized);
    }

    public function testJsonSanitization()
    {
        $json = json_encode([
            'email' => 'user@example.com',
            'password' => 'mypassword123',
            'search_preferences' => [
                'color' => 'blue',
                'size' => 'medium',
                'token' => '123123kdskakdsakdkasd'
            ]
        ]);

        $sanitized = $this->sanitizer->sanitize($json, 'json');

        $this->assertJson($sanitized);
        $this->assertStringNotContainsString('user@example.com', $sanitized);
        $this->assertStringNotContainsString('mypassword123', $sanitized);
        $this->assertStringNotContainsString('123123kdskakdsakdkasd', $sanitized);
        $this->assertStringContainsString('***', $sanitized);
    }

    public function testXmlSanitization()
    {
        $xml = <<<XML
            <?xml version='1.0' encoding='UTF-8'?>
            <user>
                <email>someone@example.com</email>
                <password>secretPass</password>
                <auth>
                    <token>secretToken</token>
                </auth>
            </user>
            XML;

        $sanitized = $this->sanitizer->sanitize($xml, 'xml');

        $this->assertStringNotContainsString('someone@example.com', $sanitized);
        $this->assertStringNotContainsString('secretPass', $sanitized);
        $this->assertStringNotContainsString('secretToken', $sanitized);
        $this->assertStringContainsString('***', $sanitized);
        $this->assertStringContainsString('<user>', $sanitized);
        $this->assertStringContainsString('<token>', $sanitized);
    }

    public function testAddingCustomPattern()
    {
        $patterns = new PatternRepository();
        $patterns->addPattern('custom_key', '/my-secret-[a-z0-9]+/', 'text');

        // Inject into a new sanitizer instance
        $sanitizer = new LogSanitizer($patterns);

        $log = 'user_id=42, custom_key=my-secret-abc123xyz';
        $sanitized = $sanitizer->sanitize($log, 'text');

        $this->assertStringNotContainsString('my-secret-abc123xyz', $sanitized);
        $this->assertStringContainsString('***', $sanitized);
    }

    public function testFallbackToTextHandler()
    {
        $input = 'api_key=abcdef1234567890';
        $sanitized = $this->sanitizer->sanitize($input, 'unknown_format');

        $this->assertStringNotContainsString('abcdef1234567890', $sanitized);
        $this->assertStringContainsString('***', $sanitized);
    }
}
