# Changelog

All notable changes to this project will be documented in this file.

## 1.0.0 - 2026-09-08

First release.

- `Zapier::send()` posts payloads to Zapier catch hooks, by full URL or by a name declared in `config('zapier.hooks')`
- Zapier REST API: `zaps()`, `zap()`, `enableZap()`, `disableZap()`, `tasks()`, `profile()`
- Client registered as a singleton, so it works via the facade or dependency injection
- Built on Laravel's HTTP client, so `Http::fake()` works in consumer tests
- PHP 8.2+, Laravel 12 and 13

## [Unreleased]
