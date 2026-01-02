<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment History</title>
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
        
        .content-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table thead th {
            background: rgba(14, 165, 233, 0.05);
            border-bottom: 2px solid rgba(14, 165, 233, 0.2);
            font-weight: 700;
            color: var(--text-primary);
            padding: 15px;
        }
        
        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid rgba(14, 165, 233, 0.1);
        }
        
        .table tbody tr:hover {
            background: rgba(14, 165, 233, 0.03);
        }
        
        .btn-back {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .btn-back:hover {
            background: rgba(14, 165, 233, 0.05);
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
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
            <i class="fas fa-history me-2"></i>Payment History
        </span>
    </div>
</nav>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-history me-2"></i>Transaction Records</span>
        <h1 class="hero-title">Payment <span>History</span></h1>
        <p class="text-muted">View all your past payment transactions</p>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('payments.index') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="content-card">
        <h4 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
            <i class="fas fa-list me-2"></i>All Transactions
        </h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Transaction ID</th>
                    <th>Invoice</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>
                            <i class="fas fa-calendar me-2 text-muted"></i>
                            {{ $payment->created_at->format('M d, Y') }}<br>
                            <small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
                        </td>
                        <td class="small font-monospace">{{ $payment->transaction_id }}</td>
                        <td>
                            @if($payment->invoice)
                                <a href="{{ route('payments.show', $payment->invoice) }}" style="color: var(--primary); text-decoration: none;">
                                    <i class="fas fa-file-invoice me-1"></i>{{ $payment->invoice->invoice_number }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->payment_type === 'bkash')
                                <i class="fas fa-mobile-alt me-1"></i>BKASH
                            @else
                                <i class="fas fa-credit-card me-1"></i>Card
                            @endif
                        </td>
                        <td class="fw-bold" style="color: var(--text-primary);">TK {{ number_format($payment->amount, 2) }}</td>
                        <td>
                            <span class="badge 
                                @if($payment->status === 'completed') text-bg-success
                                @elseif($payment->status === 'failed') text-bg-danger
                                @elseif($payment->status === 'refunded') text-bg-warning
                                @else text-bg-secondary
                                @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">No payment history found</h5>
                            <p class="text-muted small">You haven't made any payments yet.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
