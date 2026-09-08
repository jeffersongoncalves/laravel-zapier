<?php

namespace JeffersonGoncalves\Zapier;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use RuntimeException;

class Zapier
{
    /**
     * List every Zap owned by the authenticated account.
     *
     * @return array<array-key, mixed>
     */
    public function zaps(): array
    {
        return $this->get('/zaps');
    }

    /**
     * @return array<array-key, mixed>
     */
    public function zap(string $id): array
    {
        return $this->get("/zaps/{$id}");
    }

    /**
     * @return array<array-key, mixed>
     */
    public function enableZap(string $id): array
    {
        return $this->post("/zaps/{$id}/on");
    }

    /**
     * @return array<array-key, mixed>
     */
    public function disableZap(string $id): array
    {
        return $this->post("/zaps/{$id}/off");
    }

    /**
     * @return array<array-key, mixed>
     */
    public function tasks(string $zapId): array
    {
        return $this->get("/zaps/{$zapId}/tasks");
    }

    /**
     * @return array<array-key, mixed>
     */
    public function profile(): array
    {
        return $this->get('/profiles/me');
    }

    /**
     * Send a payload to a Zapier catch hook.
     *
     * $hook is either a full webhook URL or a key from `config('zapier.hooks')`.
     *
     * @param  array<array-key, mixed>  $data
     * @return array<array-key, mixed>
     */
    public function send(string $hook, array $data): array
    {
        $response = Http::acceptJson()
            ->timeout($this->timeout())
            ->post($this->hookUrl($hook), $data)
            ->throw()
            ->json();

        return is_array($response) ? $response : [];
    }

    protected function hookUrl(string $hook): string
    {
        if (str_starts_with($hook, 'http://') || str_starts_with($hook, 'https://')) {
            return $hook;
        }

        $url = config("zapier.hooks.{$hook}");

        if (! is_string($url) || $url === '') {
            throw new InvalidArgumentException("Zapier hook [{$hook}] is not configured in config/zapier.php.");
        }

        return $url;
    }

    protected function client(): PendingRequest
    {
        $apiKey = config('zapier.api_key');

        if (! is_string($apiKey) || $apiKey === '') {
            throw new RuntimeException('Zapier API key is missing. Set ZAPIER_API_KEY in your .env file.');
        }

        return Http::baseUrl((string) config('zapier.base_url', 'https://api.zapier.com/v1'))
            ->withHeaders(['X-API-Key' => $apiKey])
            ->acceptJson()
            ->asJson()
            ->timeout($this->timeout());
    }

    /**
     * @return array<array-key, mixed>
     */
    protected function get(string $path): array
    {
        $response = $this->client()->get($path)->throw()->json();

        return is_array($response) ? $response : [];
    }

    /**
     * @return array<array-key, mixed>
     */
    protected function post(string $path): array
    {
        $response = $this->client()->post($path)->throw()->json();

        return is_array($response) ? $response : [];
    }

    protected function timeout(): int
    {
        return (int) config('zapier.timeout', 10);
    }
}
