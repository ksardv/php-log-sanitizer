# PHP Log Sanitizer

A lightweight, **framework-agnostic PHP library** for automatically masking sensitive data in logs. Useful for privacy compliance (e.g., GDPR, PCI DSS) and secure debugging.

- ✅ Framework-agnostic — works with any PHP project
- ✅ Format-aware — supports plain text, JSON, XML
- ✅ Regex-based masking with override support
- ✅ Ships with secure defaults (emails, passwords, API keys, etc.)
- ✅ Configurable via external `mask.php` pattern file
- ✅ No Monolog or PSR-3 required
- ✅ Modern PHP 8.0+ (typed properties, constructor promotion)

---

## 🚀 Installation

Install via [Composer](https://getcomposer.org/):

```bash
composer require ksardv/php-log-sanitizer
```

## 🧩 Framework Integration

### Laravel

You can use `php-log-sanitizer` in Laravel without any special service provider or package.

#### Basic usage in a custom log processor:

```php
use Ksardv\PhpLogSanitizer\PatternRepository;
use Ksardv\PhpLogSanitizer\Sanitizers\JsonSanitizer;

$patterns = PatternRepository::fromFile(config_path('log_mask.php'));
$sanitizer = new JsonSanitizer($patterns);

Log::info($sanitizer->sanitize(json_encode($yourPayload)));
```

## 📁 Examples Directory

See the [`examples/`](examples/) folder for real code:
- `text.php` – raw string sanitization
- `json.php` – structured JSON masking
- `xml.php` – XML sanitization
- `add_pattern.php` – how to define custom rules