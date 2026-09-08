<?php

namespace JeffersonGoncalves\Zapier\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\Zapier\Zapier as ZapierClient;

/**
 * @method static array<array-key, mixed> zaps()
 * @method static array<array-key, mixed> zap(string $id)
 * @method static array<array-key, mixed> enableZap(string $id)
 * @method static array<array-key, mixed> disableZap(string $id)
 * @method static array<array-key, mixed> tasks(string $zapId)
 * @method static array<array-key, mixed> profile()
 * @method static array<array-key, mixed> send(string $hook, array<array-key, mixed> $data)
 *
 * @see ZapierClient
 */
class Zapier extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ZapierClient::class;
    }
}
