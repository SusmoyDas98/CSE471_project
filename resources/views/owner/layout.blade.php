<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Owner Dashboard</title>
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
        
        .nav-link {
            color: #666 !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 8px 16px !important;
            text-decoration: none;
            transition: color 0.2s;
            font-family: 'Inter', sans-serif;
        }
        
        .nav-link:hover {
            color: #1a1a1a !important;
        }
        
        .nav-link.active {
            color: #1a1a1a !important;
            font-weight: 600;
        }
        
        .notification-icon {
            position: relative;
            color: #666;
            font-size: 1.2rem;
            padding: 8px;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .notification-icon:hover {
            color: #1a1a1a;
        }
        
        .notification-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #f53003;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-upgrade {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-upgrade:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);
            color: white;
        }
        
        .btn-browse {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-browse:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            color: white;
        }
        
        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .navbar-toggler {
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            padding: 6px 10px;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(26, 26, 26, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        @media (max-width: 991px) {
            .navbar-nav {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px 0;
                gap: 12px;
            }
            
            .nav-link {
                width: 100%;
            }
            
            .btn-upgrade,
            .btn-browse {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('owner.dorms.index') }}">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="brand-text">
                <div class="brand-title">DormMate</div>
                <div class="brand-tagline">HOUSING SIMPLIFIED</div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto align-items-center">
                <a class="nav-link {{ request()->routeIs('owner.dorms.index') || request()->routeIs('owner.dorms.*') ? 'active' : '' }}" href="{{ route('owner.dorms.index') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('owner.applications.*') ? 'active' : '' }}" href="{{ route('owner.applications.index') }}">Review Applications</a>
                @php
                    $pendingApps = \App\Models\Application::whereHas('vacancy.room.dorm', function($q) {
                        $q->where('user_id', auth()->id());
                    })->where('status', 'submitted')->count();
                @endphp
                <a class="notification-icon" href="{{ route('owner.applications.index') }}" title="Notifications">
                    <i class="fas fa-bell"></i>
                    @if($pendingApps > 0)
                        <span class="notification-badge">{{ $pendingApps > 9 ? '9+' : $pendingApps }}</span>
                    @endif
                </a>
                <a href="#" class="btn-upgrade">
                    <i class="fas fa-crown"></i>
                    <span>Upgrade Plan</span>
                </a>
                <a href="{{ route('owner.dorms.index') }}" class="btn-browse">
                    <i class="fas fa-list"></i>
                    <span>Browse Properties</span>
                </a>
            </div>
        </div>
    </div>
</nav>
<div class="container mb-5">
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert" style="border-radius: 16px; border: 2px solid var(--success);">
            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
