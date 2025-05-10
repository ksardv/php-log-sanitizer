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