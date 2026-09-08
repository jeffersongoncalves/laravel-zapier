<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Zapier\Facades\Zapier;

it('lists zaps with the api key header', function () {
    Http::fake(['api.zapier.com/*' => Http::response(['data' => [['id' => '1']]])]);

    expect(Zapier::zaps())->toBe(['data' => [['id' => '1']]]);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.zapier.com/v1/zaps'
        && $request->method() === 'GET'
        && $request->header('X-API-Key') === ['test-api-key']);
});

it('gets a single zap', function () {
    Http::fake(['api.zapier.com/*' => Http::response(['id' => '42'])]);

    expect(Zapier::zap('42'))->toBe(['id' => '42']);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.zapier.com/v1/zaps/42');
});

it('turns a zap on and off', function () {
    Http::fake(['api.zapier.com/*' => Http::response(['status' => 'ok'])]);

    Zapier::enableZap('42');
    Zapier::disableZap('42');

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.zapier.com/v1/zaps/42/on' && $request->method() === 'POST');
    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.zapier.com/v1/zaps/42/off' && $request->method() === 'POST');
});

it('lists tasks for a zap', function () {
    Http::fake(['api.zapier.com/*' => Http::response(['data' => []])]);

    Zapier::tasks('42');

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.zapier.com/v1/zaps/42/tasks');
});

it('fetches the account profile', function () {
    Http::fake(['api.zapier.com/*' => Http::response(['id' => 'me'])]);

    expect(Zapier::profile())->toBe(['id' => 'me']);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.zapier.com/v1/profiles/me');
});

it('throws when the api key is missing', function () {
    config()->set('zapier.api_key', null);

    Zapier::zaps();
})->throws(RuntimeException::class);

it('sends a payload to a raw webhook url', function () {
    Http::fake(['hooks.zapier.com/*' => Http::response(['status' => 'success'])]);

    $result = Zapier::send('https://hooks.zapier.com/hooks/catch/999/zzz', ['email' => 'a@b.com']);

    expect($result)->toBe(['status' => 'success']);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://hooks.zapier.com/hooks/catch/999/zzz'
        && $request->method() === 'POST'
        && $request->data() === ['email' => 'a@b.com']);
});

it('resolves a named hook from the config', function () {
    Http::fake(['hooks.zapier.com/*' => Http::response(['status' => 'success'])]);

    Zapier::send('new-lead', ['name' => 'Ada']);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://hooks.zapier.com/hooks/catch/123/abc');
});

it('throws on an unknown named hook', function () {
    Zapier::send('nope', []);
})->throws(InvalidArgumentException::class);
