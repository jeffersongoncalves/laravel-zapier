<?php

namespace Jeffersongoncalves\Zapier\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jeffersongoncalves\Zapier\Zapier
 */
class Zapier extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-zapier';
    }
}
