<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('payments.index') }}">Payment Portal</a>
        <span class="navbar-text text-white">Invoice Details</span>
    </div>
</nav>
<div class="container mb-5">
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Invoice #{{ $invoice->invoice_number }}</h5>
                    <span class="badge 
                        @if($invoice->status === 'paid') text-bg-success
                        @elseif($invoice->status === 'overdue') text-bg-danger
                        @else text-bg-warning
                        @endif">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Type:</strong> {{ ucfirst($invoice->type) }}<br>
                            <strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}<br>
                            @if($invoice->room)
                                <strong>Dorm:</strong> {{ $invoice->room->dorm->name }}<br>
                                <strong>Room:</strong> {{ $invoice->room->label }}
                            @endif
                        </div>
                        <div class="col-md-6 text-end">
                            <h4 class="mb-0">TK {{ number_format($invoice->amount, 2) }}</h4>
                            @php
                                $paid = $invoice->payments()->where('status', 'completed')->sum('amount');
                                $remaining = $invoice->amount - $paid;
                            @endphp
                            <div class="small text-muted">
                                Paid: TK {{ number_format($paid, 2) }}<br>
                                Remaining: TK {{ number_format($remaining, 2) }}
                            </div>
                        </div>
                    </div>

                    @if($invoice->description)
                        <div class="mb-3">
                            <strong>Description:</strong>
                            <p class="mb-0">{{ $invoice->description }}</p>
                        </div>
                    @endif

                    <h6 class="mt-4 mb-3">Payment History</h6>
                    @if($invoice->payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoice->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                        <td class="small">{{ $payment->transaction_id }}</td>
                                        <td>TK {{ number_format($payment->amount, 2) }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($payment->status === 'completed') text-bg-success
                                                @elseif($payment->status === 'failed') text-bg-danger
                                                @else text-bg-warning
                                                @endif">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">No payments yet.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if(!$invoice->isPaid())
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Make Payment</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('payments.store', $invoice) }}" id="paymentForm">
                            @csrf
                            @php
                                $paid = $invoice->payments()->where('status', 'completed')->sum('amount');
                                $remaining = $invoice->amount - $paid;
                            @endphp

                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">TK</span>
                                    <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                           value="{{ old('amount', $remaining) }}" 
                                           min="1" max="{{ $remaining }}" step="0.01" required>
                                </div>
                                <small class="text-muted">Remaining: TK {{ number_format($remaining, 2) }}</small>
                                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Payment Method <span class="text-danger">*</span></label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="payment_gateway" id="bkash" value="bkash" {{ old('payment_gateway') === 'bkash' || !old('payment_gateway') ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" for="bkash" style="min-height: 80px;">
                                            <strong class="fs-5 mb-1">📱 BKASH</strong>
                                            <small class="text-muted">Mobile Payment</small>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="payment_gateway" id="card" value="card" {{ old('payment_gateway') === 'card' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" for="card" style="min-height: 80px;">
                                            <strong class="fs-5 mb-1">💳 Card</strong>
                                            <small class="text-muted">Credit/Debit Card</small>
                                        </label>
                                    </div>
                                </div>
                                @error('payment_gateway')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <!-- BKASH Payment Fields -->
                            <div id="bkashFields" class="payment-method-fields">
                                <div class="mb-3">
                                    <label class="form-label">BKASH Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" name="bkash_phone" class="form-control @error('bkash_phone') is-invalid @enderror" 
                                           value="{{ old('bkash_phone') }}" 
                                           placeholder="01XXXXXXXXX" 
                                           pattern="[0-9]{11}" maxlength="11" required>
                                    <small class="text-muted">Enter your 11-digit BKASH mobile number</small>
                                    @error('bkash_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BKASH PIN</label>
                                    <input type="password" name="bkash_pin" class="form-control @error('bkash_pin') is-invalid @enderror" 
                                           placeholder="Enter BKASH PIN (for verification)" 
                                           maxlength="4">
                                    <small class="text-muted">Required for BKASH payment verification</small>
                                    @error('bkash_pin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <!-- Card Payment Fields -->
                            <div id="cardFields" class="payment-method-fields" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Card Number <span class="text-danger">*</span></label>
                                    <input type="text" name="card_number" class="form-control @error('card_number') is-invalid @enderror" 
                                           value="{{ old('card_number') }}" 
                                           placeholder="1234 5678 9012 3456" 
                                           maxlength="19" 
                                           pattern="[0-9\s]{13,19}">
                                    <small class="text-muted">Enter 13-19 digit card number</small>
                                    @error('card_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                        <input type="text" name="card_expiry" class="form-control @error('card_expiry') is-invalid @enderror" 
                                               value="{{ old('card_expiry') }}" 
                                               placeholder="MM/YY" 
                                               maxlength="5" 
                                               pattern="[0-9]{2}/[0-9]{2}">
                                        <small class="text-muted">MM/YY</small>
                                        @error('card_expiry')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CVV <span class="text-danger">*</span></label>
                                        <input type="text" name="card_cvv" class="form-control @error('card_cvv') is-invalid @enderror" 
                                               value="{{ old('card_cvv') }}" 
                                               placeholder="123" 
                                               maxlength="4" 
                                               pattern="[0-9]{3,4}">
                                        <small class="text-muted">3-4 digits</small>
                                        @error('card_cvv')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cardholder Name <span class="text-danger">*</span></label>
                                    <input type="text" name="cardholder_name" class="form-control @error('cardholder_name') is-invalid @enderror" 
                                           value="{{ old('cardholder_name') }}" 
                                           placeholder="John Doe">
                                    @error('cardholder_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description (Optional)</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Payment notes">{{ old('description') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <span id="submitText">Process Payment</span>
                                <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                            <p class="small text-muted mt-2 mb-0">
                                <em>Secure payment processing. Your payment information is encrypted.</em>
                            </p>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-success">
                    <h6>Invoice Paid</h6>
                    <p class="mb-0">This invoice has been fully paid on {{ $invoice->paid_at->format('M d, Y') }}.</p>
                </div>
            @endif
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle payment method fields
    document.querySelectorAll('input[name="payment_gateway"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bkashFields = document.getElementById('bkashFields');
            const cardFields = document.getElementById('cardFields');
            
            if (this.value === 'bkash') {
                bkashFields.style.display = 'block';
                cardFields.style.display = 'none';
                // Make BKASH fields required
                bkashFields.querySelectorAll('input').forEach(input => {
                    if (input.name === 'bkash_phone') input.required = true;
                    if (input.name === 'bkash_pin') input.required = false;
                });
                // Remove required from card fields
                cardFields.querySelectorAll('input').forEach(input => {
                    input.required = false;
                });
            } else if (this.value === 'card') {
                bkashFields.style.display = 'none';
                cardFields.style.display = 'block';
                // Remove required from BKASH fields
                bkashFields.querySelectorAll('input').forEach(input => {
                    input.required = false;
                });
                // Make card fields required
                cardFields.querySelectorAll('input').forEach(input => {
                    input.required = true;
                });
            }
        });
    });

    // Format card number
    document.querySelector('input[name="card_number"]')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
    });

    // Format expiry date
    document.querySelector('input[name="card_expiry"]')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });

    // Format BKASH phone
    document.querySelector('input[name="bkash_phone"]')?.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });

    // Form submission
    document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');
        
        submitBtn.disabled = true;
        submitText.textContent = 'Processing...';
        submitSpinner.classList.remove('d-none');
    });

    // Trigger initial state
    document.querySelector('input[name="payment_gateway"]:checked')?.dispatchEvent(new Event('change'));
</script>
</body>
</html>

