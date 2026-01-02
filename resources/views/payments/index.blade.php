<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Portal</title>
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
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 700px;
            margin: 0 auto 40px;
        }
        
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            transition: all 0.3s;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 36px rgba(14, 165, 233, 0.15);
        }
        
        .stat-card.warning {
            border-left: 4px solid var(--gold);
        }
        
        .stat-card.danger {
            border-left: 4px solid #dc3545;
        }
        
        .stat-card.success {
            border-left: 4px solid var(--success);
        }
        
        .content-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        }
        
        .invoice-item {
            background: rgba(14, 165, 233, 0.05);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            transition: all 0.3s;
        }
        
        .invoice-item:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.1);
        }
        
        .btn-pay {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
        }
        
        .payment-method-card {
            background: rgba(14, 165, 233, 0.05);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            border: 2px solid rgba(14, 165, 233, 0.1);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="brand-text">
                <div class="brand-title">DormMate</div>
                <div class="brand-tagline">HOUSING SIMPLIFIED</div>
            </div>
        </a>
        <span class="navbar-text ms-auto" style="color: var(--text-secondary); font-weight: 600; font-size: 0.95rem; font-family: 'Inter', sans-serif;">
            <i class="fas fa-wallet me-2"></i>Payment Portal
        </span>
    </div>
</nav>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-credit-card me-2"></i>Secure Payments</span>
        <h1 class="hero-title">Payment <span>Dashboard</span></h1>
        <p class="hero-subtitle">Manage your invoices, payment methods, and payment history all in one place</p>
    </div>
</div>

<div class="container mb-5">
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card warning">
                <h6 class="text-muted mb-2"><i class="fas fa-clock me-2"></i>Pending</h6>
                <h3 class="mb-0" style="color: var(--gold); font-weight: 700;">TK {{ number_format($stats['pending'], 2) }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card danger">
                <h6 class="text-muted mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Overdue</h6>
                <h3 class="mb-0" style="color: #dc3545; font-weight: 700;">TK {{ number_format($stats['overdue'], 2) }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card success">
                <h6 class="text-muted mb-2"><i class="fas fa-check-circle me-2"></i>Paid This Month</h6>
                <h3 class="mb-0" style="color: var(--success); font-weight: 700;">TK {{ number_format($stats['paid_this_month'], 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
                        <i class="fas fa-file-invoice me-2"></i>Invoices
                    </h4>
                    <a href="{{ route('payments.history') }}" class="btn btn-outline-primary">
                        <i class="fas fa-history me-2"></i>Payment History
                    </a>
                </div>
                @forelse($invoices as $invoice)
                    <div class="invoice-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-2 fw-bold">{{ $invoice->invoice_number }}</h6>
                                <div class="small text-muted mb-2">
                                    <i class="fas fa-building me-1"></i>{{ ucfirst($invoice->type) }} - {{ $invoice->room->dorm->name ?? 'N/A' }}
                                </div>
                                <div class="small mb-2">
                                    <i class="fas fa-calendar me-1"></i>Due: {{ $invoice->due_date->format('M d, Y') }}
                                </div>
                                @if($invoice->description)
                                    <div class="small text-muted">{{ $invoice->description }}</div>
                                @endif
                            </div>
                            <div class="text-end ms-3">
                                <div class="fw-bold mb-2" style="font-size: 1.2rem; color: var(--text-primary);">
                                    TK {{ number_format($invoice->amount, 2) }}
                                </div>
                                <span class="badge 
                                    @if($invoice->status === 'paid') text-bg-success
                                    @elseif($invoice->status === 'overdue') text-bg-danger
                                    @else text-bg-warning
                                    @endif mb-2">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                                @if(!$invoice->isPaid())
                                    <div class="mt-2">
                                        <a href="{{ route('payments.show', $invoice) }}" class="btn-pay btn-sm">
                                            <i class="fas fa-credit-card me-1"></i>Pay Now
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center" style="border-radius: 20px; padding: 40px;">
                        <i class="fas fa-inbox fa-2x mb-3 text-muted"></i>
                        <h5>No invoices found</h5>
                        <p class="mb-0">You don't have any invoices at the moment.</p>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="content-card mb-4">
                <h5 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
                    <i class="fas fa-history me-2"></i>Recent Payments
                </h5>
                @forelse($payments as $payment)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="small text-muted mb-1">
                            <i class="fas fa-calendar me-1"></i>{{ $payment->created_at->format('M d, Y') }}
                        </div>
                        <div class="fw-bold mb-1" style="color: var(--text-primary);">TK {{ number_format($payment->amount, 2) }}</div>
                        <span class="badge 
                            @if($payment->status === 'completed') text-bg-success
                            @elseif($payment->status === 'failed') text-bg-danger
                            @else text-bg-warning
                            @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                @empty
                    <div class="text-muted small text-center py-3">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        No recent payments.
                    </div>
                @endforelse
            </div>

            <div class="content-card">
                <h5 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
                    <i class="fas fa-wallet me-2"></i>Payment Methods
                </h5>
                @forelse($paymentMethods as $method)
                    <div class="payment-method-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="fw-bold">
                                        @if($method->type === 'bkash')
                                            <i class="fas fa-mobile-alt me-2"></i>BKASH
                                        @else
                                            <i class="fas fa-credit-card me-2"></i>{{ $method->brand ?? 'Card' }}
                                        @endif
                                    </div>
                                    @if($method->is_default)
                                        <span class="badge text-bg-primary">Default</span>
                                    @endif
                                </div>
                                @if($method->type === 'bkash' && isset($method->metadata['phone']))
                                    <div class="small text-muted">{{ $method->metadata['phone'] }}</div>
                                @elseif($method->last_four)
                                    <div class="small text-muted">****{{ $method->last_four }}</div>
                                    @if(isset($method->metadata['cardholder_name']))
                                        <div class="small text-muted">{{ $method->metadata['cardholder_name'] }}</div>
                                    @endif
                                @endif
                            </div>
                            <div class="d-flex gap-1">
                                @if(!$method->is_default)
                                    <form method="POST" action="{{ route('payments.payment-methods.set-default', $method) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Set as default">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('payments.payment-methods.delete', $method) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this payment method?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                        <div class="text-muted small mb-3">No payment methods added.</div>
                        <a href="{{ route('payments.payment-methods.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Payment Method
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
