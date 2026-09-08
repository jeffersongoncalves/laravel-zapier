<div class="filament-hidden">

![Laravel Zapier](https://raw.githubusercontent.com/jeffersongoncalves/laravel-zapier/main/art/jeffersongoncalves-laravel-zapier.png)

</div>

# Laravel Zapier

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-zapier.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-zapier)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-zapier/pint.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-zapier/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-zapier.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-zapier)

Zapier integration for Laravel. Push payloads to Zapier catch hooks and drive the Zapier REST API — list Zaps, turn them on or off, read task history and the account profile — through a single facade.

## Features

- 🪝 Send data to Zapier catch hooks by URL or by a name declared in config
- ⚡ Manage Zaps: list, inspect, turn on, turn off
- 📜 Read the task history of a Zap
- 👤 Read the authenticated Zapier profile
- 🧪 Built on Laravel's HTTP client, so `Http::fake()` works in your tests

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-zapier
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag=laravel-zapier-config
```

Add your credentials to `.env`:

```dotenv
ZAPIER_API_KEY=your-zapier-api-key
```

The API key is only needed for the REST API calls. Sending data to a catch hook works without it.

## Usage

### Sending data to a catch hook

Create a "Webhooks by Zapier → Catch Hook" trigger in Zapier and send it anything:

```php
use JeffersonGoncalves\Zapier\Facades\Zapier;

Zapier::send('https://hooks.zapier.com/hooks/catch/123456/abcdef', [
    'name' => 'Ada Lovelace',
    'email' => 'ada@example.com',
]);
```

Prefer naming your hooks in `config/zapier.php` so URLs stay out of your code:

```php
// config/zapier.php
'hooks' => [
    'new-lead' => env('ZAPIER_HOOK_NEW_LEAD'),
],
```

```php
Zapier::send('new-lead', ['email' => 'ada@example.com']);
```

Fire and forget from a queue when the request should not block a web response:

```php
dispatch(fn () => Zapier::send('new-lead', ['email' => $user->email]));
```

### Managing Zaps

```php
Zapier::zaps();              // list every Zap
Zapier::zap('123456');       // a single Zap
Zapier::enableZap('123456'); // turn it on
Zapier::disableZap('123456');// turn it off
Zapier::tasks('123456');     // task history for a Zap
Zapier::profile();           // the authenticated account
```

### Dependency injection

The facade is optional — the client is registered as a singleton:

```php
use JeffersonGoncalves\Zapier\Zapier;

public function __construct(protected Zapier $zapier) {}
```

### Testing your own code

Because the package uses Laravel's HTTP client, fake it as usual:

```php
use Illuminate\Support\Facades\Http;

Http::fake(['hooks.zapier.com/*' => Http::response(['status' => 'success'])]);
```

## Configuration

| Key | Env | Default | Description |
| --- | --- | --- | --- |
| `api_key` | `ZAPIER_API_KEY` | `null` | Zapier personal API key, required for REST API calls |
| `base_url` | `ZAPIER_BASE_URL` | `https://api.zapier.com/v1` | Zapier REST API base URL |
| `timeout` | `ZAPIER_TIMEOUT` | `10` | HTTP timeout in seconds |
| `hooks` | — | `[]` | Named catch hook URLs |

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email the author instead of using the issue tracker.

## Credits

- [jeffersongoncalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
