<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Payment Method</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #38bdf8;
            --secondary: #06b6d4;
            --accent: #3b82f6;
            --gold: #fbbf24;
            --success: #10b981;
            --bg-main: #f0f9ff;
            --bg-secondary: #e0f2fe;
            --card-bg: #ffffff;
            --text-primary: #0c4a6e;
            --text-secondary: #075985;
            --border-color: #bae6fd;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--text-primary);
            min-height: 100vh;
        }
        
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1a1a1a;
        }
        
        .navbar-brand .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .navbar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .navbar-brand .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0284c7;
            font-family: 'Playfair Display', serif;
        }
        
        .navbar-brand .brand-tagline {
            font-size: 0.65rem;
            font-weight: 500;
            color: #0ea5e9;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-family: 'Inter', sans-serif;
        }
        
        .navbar-text {
            color: var(--text-secondary) !important;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .hero-section {
            padding: 60px 0 40px;
            text-align: center;
        }
        
        .hero-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 8px 24px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-title span {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            box-shadow: 0 20px 60px rgba(14, 165, 233, 0.12);
        }
        
        .payment-type-btn {
            border-radius: 16px;
            border: 2px solid rgba(14, 165, 233, 0.2);
            padding: 30px 20px;
            transition: all 0.3s;
            cursor: pointer;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .payment-type-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.15);
        }
        
        input[type="radio"]:checked + .payment-type-btn {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.05), rgba(59, 130, 246, 0.05));
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.2);
        }
        
        input[type="radio"]:checked + .payment-type-btn.bkash-btn {
            border-color: var(--success);
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(5, 150, 105, 0.05));
        }
        
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid rgba(14, 165, 233, 0.2);
            padding: 12px 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        
        .btn-save {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 14px 48px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
        }
        
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
        }
        
        .btn-cancel {
            background: white;
            color: var(--text-secondary);
            border: 2px solid rgba(14, 165, 233, 0.2);
            padding: 14px 48px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .btn-cancel:hover {
            border-color: var(--primary);
            background: rgba(14, 165, 233, 0.05);
        }
        
        .btn-back {
            background: white;
            color: var(--text-secondary);
            border: 2px solid rgba(14, 165, 233, 0.2);
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-back:hover {
            border-color: var(--primary);
            background: rgba(14, 165, 233, 0.05);
            color: var(--primary);
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .form-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('payments.index') }}">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="brand-text">
                <div class="brand-title">DormMate</div>
                <div class="brand-tagline">HOUSING SIMPLIFIED</div>
            </div>
        </a>
        <span class="navbar-text ms-auto">
            <i class="fas fa-wallet me-2"></i>Add Payment Method
        </span>
    </div>
</nav>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-wallet me-2"></i>Secure Setup</span>
        <h1 class="hero-title">Add Payment <span>Method</span></h1>
        <p class="text-muted">Add a new payment method for quick and easy payments</p>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('payments.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-card">
                <form method="POST" action="{{ route('payments.payment-methods.store') }}" id="paymentMethodForm">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label mb-3">Select Payment Method Type <span class="text-danger">*</span></label>
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="type" id="type_bkash" value="bkash" {{ old('type') === 'bkash' || !old('type') ? 'checked' : '' }}>
                                <label class="payment-type-btn bkash-btn w-100" for="type_bkash">
                                    <i class="fas fa-mobile-alt fa-2x mb-2" style="color: var(--success);"></i>
                                    <strong class="fs-5 mb-1">BKASH</strong>
                                    <small class="text-muted">Mobile Payment</small>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="type" id="type_card" value="card" {{ old('type') === 'card' ? 'checked' : '' }}>
                                <label class="payment-type-btn w-100" for="type_card">
                                    <i class="fas fa-credit-card fa-2x mb-2" style="color: var(--primary);"></i>
                                    <strong class="fs-5 mb-1">Card</strong>
                                    <small class="text-muted">Credit/Debit Card</small>
                                </label>
                            </div>
                        </div>
                        @error('type')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                    </div>

                    <!-- BKASH Fields -->
                    <div id="bkashFields" class="payment-type-fields">
                        <div class="mb-3">
                            <label class="form-label">BKASH Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="bkash_phone" class="form-control @error('bkash_phone') is-invalid @enderror" 
                                   value="{{ old('bkash_phone') }}" 
                                   placeholder="01XXXXXXXXX" 
                                   pattern="[0-9]{11}" maxlength="11" required>
                            <small class="text-muted">Enter your 11-digit BKASH mobile number</small>
                            @error('bkash_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Card Fields -->
                    <div id="cardFields" class="payment-type-fields" style="display: none;">
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

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_default">
                                Set as default payment method
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save me-2"></i>Save Payment Method
                        </button>
                        <a href="{{ route('payments.index') }}" class="btn-cancel">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle payment type fields
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bkashFields = document.getElementById('bkashFields');
            const cardFields = document.getElementById('cardFields');
            
            if (this.value === 'bkash') {
                bkashFields.style.display = 'block';
                cardFields.style.display = 'none';
                // Make BKASH fields required
                bkashFields.querySelectorAll('input').forEach(input => {
                    if (input.name === 'bkash_phone') input.required = true;
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

    // Trigger initial state
    document.querySelector('input[name="type"]:checked')?.dispatchEvent(new Event('change'));
</script>
</body>
</html>
