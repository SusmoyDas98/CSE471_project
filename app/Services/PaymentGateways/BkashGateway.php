<?php

namespace App\Services\PaymentGateways;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BkashGateway
{
    private $apiUrl;
    private $username;
    private $password;
    private $appKey;
    private $appSecret;

    public function __construct()
    {
        // Load from config/env - In production, use config('services.bkash.*')
        $this->apiUrl = env('BKASH_API_URL', 'https://tokenized.sandbox.bka.sh/v1.2.0-beta');
        $this->username = env('BKASH_USERNAME', '');
        $this->password = env('BKASH_PASSWORD', '');
        $this->appKey = env('BKASH_APP_KEY', '');
        $this->appSecret = env('BKASH_APP_SECRET', '');
    }

    /**
     * Process BKASH payment
     */
    public function processPayment(Payment $payment, array $data): array
    {
        try {
            // Step 1: Get Grant Token
            $grantToken = $this->getGrantToken();
            if (!$grantToken) {
                return ['success' => false, 'message' => 'Failed to authenticate with BKASH'];
            }

            // Step 2: Get Access Token
            $accessToken = $this->getAccessToken($grantToken);
            if (!$accessToken) {
                return ['success' => false, 'message' => 'Failed to get access token'];
            }

            // Step 3: Create Payment
            $paymentResponse = $this->createPayment($accessToken, $payment, $data);

            if ($paymentResponse['success']) {
                // Step 4: Execute Payment (in production, this would be done via callback)
                $executeResponse = $this->executePayment($accessToken, $paymentResponse['paymentID']);

                if ($executeResponse['success']) {
                    return [
                        'success' => true,
                        'transaction_id' => $paymentResponse['paymentID'],
                        'status' => 'completed',
                        'metadata' => $executeResponse
                    ];
                }
            }

            return [
                'success' => false,
                'message' => $paymentResponse['message'] ?? 'Payment processing failed'
            ];
        } catch (\Exception $e) {
            Log::error('BKASH Payment Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Payment processing error occurred'];
        }
    }

    /**
     * Get Grant Token from BKASH
     */
    private function getGrantToken(): ?string
    {
        try {
            $response = Http::withHeaders([
                'username' => $this->username,
                'password' => $this->password,
            ])->post($this->apiUrl . '/tokenized/checkout/token/grant', [
                'app_key' => $this->appKey,
                'app_secret' => $this->appSecret,
            ]);

            if ($response->successful() && $response->json('id_token')) {
                return $response->json('id_token');
            }

            return null;
        } catch (\Exception $e) {
            Log::error('BKASH Grant Token Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get Access Token using Grant Token
     */
    private function getAccessToken(string $grantToken): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $grantToken,
                'X-App-Key' => $this->appKey,
            ])->post($this->apiUrl . '/tokenized/checkout/token/refresh', [
                'app_key' => $this->appKey,
                'app_secret' => $this->appSecret,
            ]);

            if ($response->successful() && $response->json('token')) {
                return $response->json('token');
            }

            return null;
        } catch (\Exception $e) {
            Log::error('BKASH Access Token Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create Payment in BKASH
     */
    private function createPayment(string $accessToken, Payment $payment, array $data): array
    {
        try {
            $amount = $payment->amount; // Amount in Taka (BDT)

            $response = Http::withHeaders([
                'Authorization' => $accessToken,
                'X-App-Key' => $this->appKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/tokenized/checkout/payment/create', [
                'mode' => '0011', // Checkout mode
                'payerReference' => $data['bkash_phone'] ?? '',
                'callbackURL' => route('payments.bkash.callback'),
                'amount' => (string)$amount,
                'currency' => 'BDT',
                'intent' => 'sale',
                'merchantInvoiceNumber' => $payment->transaction_id,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['paymentID'])) {
                    return [
                        'success' => true,
                        'paymentID' => $responseData['paymentID'],
                        'bkashURL' => $responseData['bkashURL'] ?? null,
                    ];
                }
            }

            return [
                'success' => false,
                'message' => $response->json('errorMessage') ?? 'Failed to create payment'
            ];
        } catch (\Exception $e) {
            Log::error('BKASH Create Payment Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Payment creation failed'];
        }
    }

    /**
     * Execute Payment (after user confirms in BKASH)
     */
    private function executePayment(string $accessToken, string $paymentID): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $accessToken,
                'X-App-Key' => $this->appKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/tokenized/checkout/payment/execute/' . $paymentID);

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['transactionStatus']) && $responseData['transactionStatus'] === 'Completed') {
                    return [
                        'success' => true,
                        'transactionID' => $responseData['trxID'] ?? null,
                        'data' => $responseData,
                    ];
                }
            }

            return [
                'success' => false,
                'message' => $response->json('errorMessage') ?? 'Payment execution failed'
            ];
        } catch (\Exception $e) {
            Log::error('BKASH Execute Payment Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Payment execution failed'];
        }
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(string $paymentID): array
    {
        try {
            $grantToken = $this->getGrantToken();
            if (!$grantToken) {
                return ['success' => false, 'message' => 'Authentication failed'];
            }

            $accessToken = $this->getAccessToken($grantToken);
            if (!$accessToken) {
                return ['success' => false, 'message' => 'Failed to get access token'];
            }

            $response = Http::withHeaders([
                'Authorization' => $accessToken,
                'X-App-Key' => $this->appKey,
            ])->get($this->apiUrl . '/tokenized/checkout/payment/query/' . $paymentID);

            if ($response->successful()) {
                $responseData = $response->json();
                return [
                    'success' => true,
                    'status' => $responseData['transactionStatus'] ?? 'Unknown',
                    'data' => $responseData,
                ];
            }

            return ['success' => false, 'message' => 'Failed to verify payment'];
        } catch (\Exception $e) {
            Log::error('BKASH Verify Payment Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Verification failed'];
        }
    }
}
