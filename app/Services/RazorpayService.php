<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class RazorpayService
{
    private const BASE_URL = 'https://api.razorpay.com/v1';

    public function createOrder(string $receipt, int $amountInPaise, string $currency = 'INR', array $notes = []): array
    {
        $this->ensureConfigured();

        $response = Http::withBasicAuth($this->key(), $this->secret())
            ->acceptJson()
            ->post(self::BASE_URL.'/orders', [
                'receipt' => $receipt,
                'amount' => $amountInPaise,
                'currency' => $currency,
                'notes' => $notes,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException(
                'Unable to create Razorpay order: '.($response->json('error.description') ?: $response->body())
            );
        }

        return $response->json();
    }

    public function verifyPaymentSignature(string $razorpayOrderId, string $razorpayPaymentId, string $razorpaySignature): bool
    {
        $this->ensureConfigured();

        $generatedSignature = hash_hmac(
            'sha256',
            $razorpayOrderId.'|'.$razorpayPaymentId,
            $this->secret()
        );

        return hash_equals($generatedSignature, $razorpaySignature);
    }

    public function verifyWebhookSignature(string $payload, ?string $signature): bool
    {
        $this->ensureConfigured();

        $webhookSecret = config('services.razorpay.webhook_secret');

        if (! $signature || ! $webhookSecret) {
            return false;
        }

        $generatedSignature = hash_hmac('sha256', $payload, $webhookSecret);

        return hash_equals($generatedSignature, $signature);
    }

    public function key(): string
    {
        return (string) config('services.razorpay.key');
    }

    private function secret(): string
    {
        return (string) config('services.razorpay.secret');
    }

    private function ensureConfigured(): void
    {
        if (! $this->key() || ! $this->secret()) {
            throw new RuntimeException('Razorpay credentials are not configured.');
        }
    }
}
