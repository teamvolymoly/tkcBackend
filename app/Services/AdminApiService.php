<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminApiService
{
    public function __construct(private readonly Request $request)
    {
    }

    public function login(array $credentials): array
    {
        return $this->request('post', 'auth/login', $credentials, false);
    }

    public function logout(?string $token = null): array
    {
        return $this->request('post', 'auth/logout', [], true, $token);
    }

    public function profile(?string $token = null): array
    {
        return $this->request('get', 'auth/profile', [], true, $token);
    }

    public function get(string $endpoint, array $query = [], ?string $token = null): array
    {
        return $this->request('get', $endpoint, $query, true, $token);
    }

    public function post(string $endpoint, array $payload = [], ?string $token = null): array
    {
        return $this->request('post', $endpoint, $payload, true, $token);
    }

    public function put(string $endpoint, array $payload = [], ?string $token = null): array
    {
        return $this->request('put', $endpoint, $payload, true, $token);
    }

    public function delete(string $endpoint, array $payload = [], ?string $token = null): array
    {
        return $this->request('delete', $endpoint, $payload, true, $token);
    }

    public function postMultipart(string $endpoint, array $payload = [], array $files = [], ?string $token = null): array
    {
        return $this->requestMultipart('post', $endpoint, $payload, $files, true, $token);
    }

    public function putMultipart(string $endpoint, array $payload = [], array $files = [], ?string $token = null): array
    {
        return $this->requestMultipart('put', $endpoint, $payload, $files, true, $token);
    }

    private function request(string $method, string $endpoint, array $payload = [], bool $authenticated = true, ?string $token = null): array
    {
        $client = $this->client($authenticated, $token);
        $url = $this->url($endpoint);

        try {
            $response = match (strtolower($method)) {
                'get' => $client->get($url, $payload),
                'post' => $client->post($url, $payload),
                'put' => $client->put($url, $payload),
                'delete' => empty($payload) ? $client->delete($url) : $client->send('DELETE', $url, ['json' => $payload]),
                default => throw new \InvalidArgumentException("Unsupported method [{$method}]"),
            };
        } catch (ConnectionException $exception) {
            return $this->connectionFailure($endpoint, $method, $exception);
        }

        if ($response->failed()) {
            Log::info('Admin API request returned non-success response', [
                'endpoint' => $endpoint,
                'method' => $method,
                'status' => $response->status(),
                'response' => $response->json(),
            ]);
        }

        return $this->formatResponse($response);
    }

    private function requestMultipart(string $method, string $endpoint, array $payload = [], array $files = [], bool $authenticated = true, ?string $token = null): array
    {
        $client = $this->multipartClient($authenticated, $token);
        $url = $this->url($endpoint);
        $multipart = [];

        if (strtolower($method) === 'put') {
            $payload['_method'] = 'PUT';
            $method = 'post';
        }

        foreach ($this->flattenMultipartPayload($payload) as $key => $value) {
            if ($value === null) {
                continue;
            }

            $multipart[] = [
                'name' => $key,
                'contents' => (string) $value,
            ];
        }

        foreach ($this->flattenMultipartFiles($files) as $key => $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $multipart[] = [
                'name' => $key,
                'contents' => fopen($file->getRealPath(), 'r'),
                'filename' => $file->getClientOriginalName(),
                'headers' => [
                    'Content-Type' => $file->getMimeType() ?: 'application/octet-stream',
                ],
            ];
        }

        try {
            $response = $client->send(strtoupper($method), $url, [
                'multipart' => $multipart,
            ]);
        } catch (ConnectionException $exception) {
            return $this->connectionFailure($endpoint, $method, $exception);
        }

        if ($response->failed()) {
            Log::info('Admin API multipart request returned non-success response', [
                'endpoint' => $endpoint,
                'method' => $method,
                'status' => $response->status(),
                'response' => $response->json(),
            ]);
        }

        return $this->formatResponse($response);
    }

    private function flattenMultipartPayload(array $payload, string $prefix = ''): array
    {
        $flattened = [];

        foreach ($payload as $key => $value) {
            $name = $prefix === '' ? (string) $key : "{$prefix}[{$key}]";

            if (is_array($value)) {
                $flattened += $this->flattenMultipartPayload($value, $name);
                continue;
            }

            if ($value instanceof UploadedFile) {
                continue;
            }

            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }

            $flattened[$name] = $value;
        }

        return $flattened;
    }

    private function flattenMultipartFiles(array $files, string $prefix = ''): array
    {
        $flattened = [];

        foreach ($files as $key => $value) {
            $name = $prefix === '' ? (string) $key : "{$prefix}[{$key}]";

            if ($value instanceof UploadedFile) {
                $flattened[$name] = $value;
                continue;
            }

            if (is_array($value)) {
                $flattened += $this->flattenMultipartFiles($value, $name);
            }
        }

        return $flattened;
    }

    private function client(bool $authenticated = true, ?string $token = null): PendingRequest
    {
        $client = Http::acceptJson()
            ->asJson()
            ->retry(2, 250, throw: false)
            ->connectTimeout((int) config('services.admin_api.connect_timeout', 5))
            ->timeout((int) config('services.admin_api.timeout', 15));

        $token = $token ?? Session::get('admin_token');

        if ($authenticated && $token) {
            $client = $client->withToken($token);
        }

        return $client;
    }

    private function multipartClient(bool $authenticated = true, ?string $token = null): PendingRequest
    {
        $client = Http::acceptJson()
            ->retry(2, 250, throw: false)
            ->connectTimeout((int) config('services.admin_api.connect_timeout', 5))
            ->timeout((int) config('services.admin_api.timeout', 15));

        $token = $token ?? Session::get('admin_token');

        if ($authenticated && $token) {
            $client = $client->withToken($token);
        }

        return $client;
    }

    private function url(string $endpoint): string
    {
        $base = config('services.admin_api.base_url');

        if (! $base) {
            // Build the API URL from the active request so subdirectory installs
            // such as /theKawaCompany/public resolve to the correct /api path.
            $base = url('/api');
        }

        return rtrim($base, '/').'/'.ltrim($endpoint, '/');
    }

    private function connectionFailure(string $endpoint, string $method, ConnectionException $exception): array
    {
        Log::warning('Admin API connection failed', [
            'endpoint' => $endpoint,
            'method' => $method,
            'message' => $exception->getMessage(),
        ]);

        return [
            'ok' => false,
            'status' => 503,
            'message' => 'Admin panel API se connect nahi ho pa raha. XAMPP Apache start karke project ko localhost URL se kholiye, ya ADMIN_API_BASE_URL sahi set kijiye.',
            'data' => null,
            'errors' => [],
            'raw' => ['message' => $exception->getMessage()],
        ];
    }

    private function formatResponse(Response $response): array
    {
        $json = $response->json();
        $message = is_array($json) ? ($json['message'] ?? null) : null;
        $errors = is_array($json) ? ($json['errors'] ?? []) : [];
        $data = is_array($json) && array_key_exists('data', $json) ? $json['data'] : $json;

        return [
            'ok' => $response->successful(),
            'status' => $response->status(),
            'message' => $message,
            'data' => $data,
            'errors' => is_array($errors) ? $errors : [],
            'raw' => is_array($json) ? $json : ['message' => $response->body()],
        ];
    }
}


