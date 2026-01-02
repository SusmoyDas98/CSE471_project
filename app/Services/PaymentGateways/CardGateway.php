<?php

namespace App\Services\PaymentGateways;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CardGateway
{
    private $apiUrl;
    private $apiKey;
    private $secretKey;

    public function __construct()
    {
        // Load from config/env - In production, use config('services.stripe.*') or similar
        // This example uses Stripe-like structure, but can be adapted to any card payment gateway
        $this->apiUrl = env('CARD_GATEWAY_URL', 'https://api.stripe.com/v1');
        $this->apiKey = env('CARD_GATEWAY_API_KEY', '');
        $this->secretKey = env('CARD_GATEWAY_SECRET_KEY', '');
    }

    /**
     * Process Card payment
     */
    public function processPayment(Payment $payment, array $data): array
    {
        try {
            // Validate card data
            $validation = $this->validateCardData($data);
            if (!$validation['valid']) {
                return ['success' => false, 'message' => $validation['message']];
            }

            // Create payment intent (Stripe-like approach)
            $paymentIntent = $this->createPaymentIntent($payment, $data);

            if (!$paymentIntent['success']) {
                return $paymentIntent;
            }

            // Confirm payment (in production, this would handle 3D Secure, etc.)
            $confirmResponse = $this->confirmPayment($paymentIntent['client_secret'], $data);

            if ($confirmResponse['success']) {
                return [
                    'success' => true,
                    'transaction_id' => $confirmResponse['transaction_id'],
                    'status' => 'completed',
                    'metadata' => $confirmResponse['metadata'] ?? []
                ];
            }

            return [
                'success' => false,
                'message' => $confirmResponse['message'] ?? 'Payment processing failed'
            ];
        } catch (\Exception $e) {
            Log::error('Card Payment Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Payment processing error occurred'];
        }
    }

    /**
     * Validate card data
     */
    private function validateCardData(array $data): array
    {
        if (empty($data['card_number'])) {
            return ['valid' => false, 'message' => 'Card number is required'];
        }

        if (empty($data['card_expiry'])) {
            return ['valid' => false, 'message' => 'Card expiry date is required'];
        }

        if (empty($data['card_cvv'])) {
            return ['valid' => false, 'message' => 'CVV is required'];
        }

        // Validate card number (Luhn algorithm)
        $cardNumber = preg_replace('/\s+/', '', $data['card_number']);
        if (!$this->validateLuhn($cardNumber)) {
            return ['valid' => false, 'message' => 'Invalid card number'];
        }

        // Validate expiry date
        $expiry = explode('/', $data['card_expiry']);
        if (count($expiry) !== 2) {
            return ['valid' => false, 'message' => 'Invalid expiry date format'];
        }

        $month = (int)$expiry[0];
        $year = 2000 + (int)$expiry[1]; // Convert YY to YYYY

        if ($month < 1 || $month > 12) {
            return ['valid' => false, 'message' => 'Invalid expiry month'];
        }

        $expiryDate = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();
        if ($expiryDate->isPast()) {
            return ['valid' => false, 'message' => 'Card has expired'];
        }

        return ['valid' => true];
    }

    /**
     * Validate card number using Luhn algorithm
     */
    private function validateLuhn(string $cardNumber): bool
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);
        $length = strlen($cardNumber);

        if ($length < 13 || $length > 19) {
            return false;
        }

        $sum = 0;
        $alternate = false;

        for ($i = $length - 1; $i >= 0; $i--) {
            $digit = (int)$cardNumber[$i];

            if ($alternate) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
            $alternate = !$alternate;
        }

        return ($sum % 10) === 0;
    }

    /**
     * Create payment intent
     */
    private function createPaymentIntent(Payment $payment, array $data): array
    {
        try {
            // In production, this would call Stripe API or similar
            // For demo purposes, we'll simulate the API call

            $amount = $payment->amount; // Amount in Taka (BDT)

            // Simulated API call - Replace with actual gateway API
            /*
            $response = Http::withBasicAuth($this->secretKey, '')
                ->asForm()
                ->post($this->apiUrl . '/payment_intents', [
                    'amount' => $amount,
                    'currency' => strtolower($payment->currency),
                    'payment_method_types' => ['card'],
                    'metadata' => [
                        'invoice_id' => $payment->invoice_id,
                        'user_id' => $payment->user_id,
                    ],
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'client_secret' => $response->json('client_secret'),
                    'payment_intent_id' => $response->json('id'),
                ];
            }
            */

            // Demo: Return simulated success
            return [
                'success' => true,
                'client_secret' => 'pi_' . strtoupper(\Illuminate\Support\Str::random(24)),
                'payment_intent_id' => 'pi_' . strtoupper(\Illuminate\Support\Str::random(24)),
            ];
        } catch (\Exception $e) {
            Log::error('Card Payment Intent Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create payment intent'];
        }
    }

    /**
     * Confirm payment
     */
    private function confirmPayment(string $clientSecret, array $data): array
    {
        try {
            // In production, this would confirm with the payment gateway
            // For demo, we'll simulate success

            // Simulated API call
            /*
            $response = Http::withBasicAuth($this->secretKey, '')
                ->asForm()
                ->post($this->apiUrl . '/payment_intents/' . $paymentIntentId . '/confirm', [
                    'payment_method' => [
                        'type' => 'card',
                        'card' => [
                            'number' => $data['card_number'],
                            'exp_month' => explode('/', $data['card_expiry'])[0],
                            'exp_year' => '20' . explode('/', $data['card_expiry'])[1],
                            'cvc' => $data['card_cvv'],
                        ],
                    ],
                ]);

            if ($response->successful() && $response->json('status') === 'succeeded') {
                return [
                    'success' => true,
                    'transaction_id' => $response->json('charges.data.0.id'),
                    'metadata' => $response->json(),
                ];
            }
            */

            // Demo: Simulate successful payment
            return [
                'success' => true,
                'transaction_id' => 'ch_' . strtoupper(\Illuminate\Support\Str::random(24)),
                'metadata' => [
                    'card_last4' => substr(preg_replace('/\s+/', '', $data['card_number']), -4),
                    'card_brand' => $this->detectCardBrand($data['card_number']),
                ],
            ];
        } catch (\Exception $e) {
            Log::error('Card Payment Confirm Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Payment confirmation failed'];
        }
    }

    /**
     * Detect card brand from card number
     */
    private function detectCardBrand(string $cardNumber): string
    {
        $cardNumber = preg_replace('/\s+/', '', $cardNumber);
        $firstDigit = substr($cardNumber, 0, 1);
        $firstTwoDigits = substr($cardNumber, 0, 2);

        if ($firstDigit == '4') {
            return 'Visa';
        } elseif ($firstTwoDigits >= '51' && $firstTwoDigits <= '55') {
            return 'Mastercard';
        } elseif ($firstTwoDigits == '34' || $firstTwoDigits == '37') {
            return 'American Express';
        } elseif ($firstTwoDigits == '62') {
            return 'UnionPay';
        } else {
            return 'Unknown';
        }
    }
}
