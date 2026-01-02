<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Services\PaymentGateways\BkashGateway;
use App\Services\PaymentGateways\CardGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invoices = $user->invoices()->with('room.dorm')->latest()->paginate(15);
        $payments = $user->payments()->with('invoice')->latest()->take(10)->get();
        $paymentMethods = $user->paymentMethods()->latest()->get();

        $stats = [
            'pending' => $user->invoices()->where('status', 'pending')->sum('amount'),
            'overdue' => $user->invoices()->where('status', 'overdue')->sum('amount'),
            'paid_this_month' => $user->payments()
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];

        return view('payments.index', compact('invoices', 'payments', 'paymentMethods', 'stats'));
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        $invoice->load('room.dorm', 'payments.paymentMethod');
        $paymentMethods = Auth::user()->paymentMethods()->where('is_default', true)->first();

        return view('payments.show', compact('invoice', 'paymentMethods'));
    }

    public function store(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        if ($invoice->isPaid()) {
            return back()->withErrors(['error' => 'Invoice already paid.']);
        }

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:' . $invoice->amount],
            'payment_gateway' => ['required', 'in:bkash,card'],
            'description' => ['nullable', 'string', 'max:500'],
            // BKASH fields
            'bkash_phone' => ['required_if:payment_gateway,bkash', 'string', 'regex:/^01[3-9]\d{8}$/'],
            'bkash_pin' => ['nullable', 'string', 'max:4'],
            // Card fields
            'card_number' => ['required_if:payment_gateway,card', 'string'],
            'card_expiry' => ['required_if:payment_gateway,card', 'string', 'regex:/^\d{2}\/\d{2}$/'],
            'card_cvv' => ['required_if:payment_gateway,card', 'string', 'regex:/^\d{3,4}$/'],
            'cardholder_name' => ['required_if:payment_gateway,card', 'string', 'max:255'],
        ]);

        $amount = $data['amount'];
        $remaining = $invoice->amount - $invoice->payments()->where('status', 'completed')->sum('amount');

        if ($amount > $remaining) {
            return back()->withErrors(['amount' => 'Amount exceeds remaining balance.']);
        }

        // Create payment record
        $payment = Payment::create([
            'user_id' => Auth::id(),
            'invoice_id' => $invoice->id,
            'payment_method_id' => null,
            'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
            'amount' => $amount,
            'currency' => 'BDT', // All payments in Bangladeshi Taka
            'status' => 'pending',
            'payment_type' => $invoice->type,
            'description' => $data['description'] ?? "Payment for invoice {$invoice->invoice_number}",
            'metadata' => [
                'gateway' => $data['payment_gateway'],
                'bkash_phone' => $data['bkash_phone'] ?? null,
                'card_last4' => $data['payment_gateway'] === 'card' ? substr(preg_replace('/\s+/', '', $data['card_number']), -4) : null,
            ],
        ]);

        // Process payment based on selected gateway
        try {
            if ($data['payment_gateway'] === 'bkash') {
                $gateway = new BkashGateway();
                $result = $gateway->processPayment($payment, $data);
            } else {
                $gateway = new CardGateway();
                $result = $gateway->processPayment($payment, $data);
            }

            if ($result['success']) {
                $payment->update([
                    'status' => $result['status'] ?? 'completed',
                    'transaction_id' => $result['transaction_id'] ?? $payment->transaction_id,
                    'processed_at' => now(),
                    'metadata' => array_merge($payment->metadata ?? [], $result['metadata'] ?? []),
                ]);

                // Update invoice status if fully paid
                $totalPaid = $invoice->payments()->where('status', 'completed')->sum('amount');
                if ($totalPaid >= $invoice->amount) {
                    $invoice->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
                } elseif ($invoice->due_date < now() && $invoice->status === 'pending') {
                    $invoice->update(['status' => 'overdue']);
                }

                return redirect()->route('payments.show', $invoice)
                    ->with('status', 'Payment processed successfully via ' . strtoupper($data['payment_gateway']) . '.');
            } else {
                $payment->update([
                    'status' => 'failed',
                    'metadata' => array_merge($payment->metadata ?? [], ['error' => $result['message']]),
                ]);

                return back()->withErrors(['error' => $result['message'] ?? 'Payment processing failed.']);
            }
        } catch (\Exception $e) {
            $payment->update([
                'status' => 'failed',
                'metadata' => array_merge($payment->metadata ?? [], ['error' => $e->getMessage()]),
            ]);

            return back()->withErrors(['error' => 'An error occurred while processing your payment. Please try again.']);
        }
    }

    public function history()
    {
        $payments = Auth::user()->payments()->with('invoice.room.dorm')->latest()->paginate(20);

        return view('payments.history', compact('payments'));
    }

    /**
     * Handle BKASH payment callback
     */
    public function bkashCallback(Request $request)
    {
        // This endpoint receives callback from BKASH after payment
        $data = $request->validate([
            'paymentID' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);

        // Find payment by transaction ID or payment ID
        $payment = Payment::where('transaction_id', $data['paymentID'])
            ->orWhereJsonContains('metadata->paymentID', $data['paymentID'])
            ->first();

        if (!$payment) {
            return response()->json(['success' => false, 'message' => 'Payment not found'], 404);
        }

        // Verify payment with BKASH
        $gateway = new BkashGateway();
        $verification = $gateway->verifyPayment($data['paymentID']);

        if ($verification['success'] && $verification['status'] === 'Completed') {
            $payment->update([
                'status' => 'completed',
                'processed_at' => now(),
                'metadata' => array_merge($payment->metadata ?? [], $verification['data'] ?? []),
            ]);

            // Update invoice status
            $invoice = $payment->invoice;
            if ($invoice) {
                $totalPaid = $invoice->payments()->where('status', 'completed')->sum('amount');
                if ($totalPaid >= $invoice->amount) {
                    $invoice->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Payment verified']);
        }

        $payment->update([
            'status' => 'failed',
            'metadata' => array_merge($payment->metadata ?? [], ['callback_error' => $verification['message'] ?? 'Verification failed']),
        ]);

        return response()->json(['success' => false, 'message' => 'Payment verification failed'], 400);
    }

    /**
     * Show form to add payment method
     */
    public function createPaymentMethod()
    {
        return view('payments.payment-methods.create');
    }

    /**
     * Store new payment method
     */
    public function storePaymentMethod(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:bkash,card'],
            'bkash_phone' => ['required_if:type,bkash', 'nullable', 'string', 'regex:/^01[3-9]\d{8}$/'],
            'card_number' => ['required_if:type,card', 'nullable', 'string'],
            'card_expiry' => ['required_if:type,card', 'nullable', 'string', 'regex:/^\d{2}\/\d{2}$/'],
            'card_cvv' => ['required_if:type,card', 'nullable', 'string', 'regex:/^\d{3,4}$/'],
            'cardholder_name' => ['required_if:type,card', 'nullable', 'string', 'max:255'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $user = Auth::user();

        // If setting as default, unset other defaults
        if ($request->boolean('is_default')) {
            $user->paymentMethods()->update(['is_default' => false]);
        }

        $paymentMethodData = [
            'user_id' => $user->id,
            'type' => $data['type'],
            'is_default' => $request->boolean('is_default'),
        ];

        if ($data['type'] === 'bkash') {
            $paymentMethodData['provider'] = 'bkash';
            $paymentMethodData['last_four'] = substr($data['bkash_phone'], -4);
            $paymentMethodData['metadata'] = [
                'phone' => $data['bkash_phone'],
            ];
        } else {
            $cardNumber = preg_replace('/\s+/', '', $data['card_number']);
            $paymentMethodData['provider'] = 'card_gateway';
            $paymentMethodData['last_four'] = substr($cardNumber, -4);

            // Detect card brand
            $firstDigit = substr($cardNumber, 0, 1);
            $firstTwoDigits = substr($cardNumber, 0, 2);
            if ($firstDigit == '4') {
                $paymentMethodData['brand'] = 'Visa';
            } elseif ($firstTwoDigits >= '51' && $firstTwoDigits <= '55') {
                $paymentMethodData['brand'] = 'Mastercard';
            } elseif ($firstTwoDigits == '34' || $firstTwoDigits == '37') {
                $paymentMethodData['brand'] = 'American Express';
            } else {
                $paymentMethodData['brand'] = 'Unknown';
            }

            $paymentMethodData['metadata'] = [
                'cardholder_name' => $data['cardholder_name'],
                'expiry' => $data['card_expiry'],
                // Note: In production, CVV should NEVER be stored
            ];
        }

        PaymentMethod::create($paymentMethodData);

        return redirect()->route('payments.index')
            ->with('status', 'Payment method added successfully.');
    }

    /**
     * Delete payment method
     */
    public function deletePaymentMethod(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        $paymentMethod->delete();

        return redirect()->route('payments.index')
            ->with('status', 'Payment method deleted successfully.');
    }

    /**
     * Set payment method as default
     */
    public function setDefaultPaymentMethod(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        // Unset all other defaults
        Auth::user()->paymentMethods()->update(['is_default' => false]);

        // Set this as default
        $paymentMethod->update(['is_default' => true]);

        return redirect()->route('payments.index')
            ->with('status', 'Default payment method updated.');
    }
}
