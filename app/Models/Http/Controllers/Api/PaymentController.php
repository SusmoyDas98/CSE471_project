<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $payments = Auth::user()->payments()
            ->with(['invoice.room.dorm', 'paymentMethod'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }

    public function show(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $payment->load(['invoice.room.dorm', 'paymentMethod']);

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_id' => ['required', 'exists:invoices,id'],
            'amount' => ['required', 'integer', 'min:1'],
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

        $invoice = Invoice::findOrFail($data['invoice_id']);

        if ($invoice->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($invoice->isPaid()) {
            return response()->json(['success' => false, 'message' => 'Invoice already paid'], 400);
        }

        $amount = $data['amount'];
        $remaining = $invoice->amount - $invoice->payments()->where('status', 'completed')->sum('amount');

        if ($amount > $remaining) {
            return response()->json(['success' => false, 'message' => 'Amount exceeds remaining balance'], 400);
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

                $payment->load(['invoice.room.dorm', 'paymentMethod']);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment processed successfully via ' . strtoupper($data['payment_gateway']),
                    'data' => $payment,
                ], 201);
            } else {
                $payment->update([
                    'status' => 'failed',
                    'metadata' => array_merge($payment->metadata ?? [], ['error' => $result['message']]),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Payment processing failed',
                ], 400);
            }
        } catch (\Exception $e) {
            $payment->update([
                'status' => 'failed',
                'metadata' => array_merge($payment->metadata ?? [], ['error' => $e->getMessage()]),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your payment',
            ], 500);
        }
    }

    public function pendingInvoices()
    {
        $invoices = Auth::user()->invoices()
            ->whereIn('status', ['pending', 'overdue'])
            ->with('room.dorm')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $invoices,
        ]);
    }

    public function history()
    {
        $payments = Auth::user()->payments()
            ->with(['invoice.room.dorm', 'paymentMethod'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }
}
