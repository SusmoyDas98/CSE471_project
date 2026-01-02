<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dorm Communities</title>
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            color: #666 !important;
            font-weight: 600;
            font-size: 0.95rem;
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
        
        .community-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            border: 2px solid rgba(14, 165, 233, 0.1);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        
        .community-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
        }
        
        .community-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 36px rgba(14, 165, 233, 0.15);
            border-color: var(--primary);
        }
        
        .community-card h5 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 10px;
        }
        
        .message-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .btn-enter {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-enter:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
        }
        
        .btn-leave {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-leave:hover {
            background: rgba(14, 165, 233, 0.05);
        }
        
        .btn-join {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-join:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
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
        <a class="navbar-brand" href="/">
            <div class="logo-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="brand-text">
                <div class="brand-title">DormMate</div>
                <div class="brand-tagline">HOUSING SIMPLIFIED</div>
            </div>
        </a>
        <span class="navbar-text ms-auto">
            <i class="fas fa-comments me-2"></i>Community Forum
        </span>
    </div>
</nav>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-users me-2"></i>Connect & Share</span>
        <h1 class="hero-title">Dorm <span>Communities</span></h1>
        <p class="hero-subtitle">Join dorm communities to connect with residents, share updates, and stay informed</p>
    </div>
</div>

<div class="container mb-5">
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($dorms as $dorm)
            <div class="col-md-6 mb-4">
                <div class="community-card">
                    <span class="message-badge">{{ $dorm->community_posts_count }} messages</span>
                    <h5>{{ $dorm->name }}</h5>
                    <div class="text-muted mb-3"><i class="fas fa-map-marker-alt me-2"></i>{{ $dorm->city ?? '—' }}</div>
                    <p class="text-secondary mb-4">{{ \Illuminate\Support\Str::limit($dorm->description, 120) }}</p>
                    <div class="d-flex gap-2">
                        @php
                            $isMember = in_array($dorm->id, $memberships);
                        @endphp
                        @if($isMember)
                            <a class="btn-enter" href="{{ route('community.show', $dorm) }}">
                                <i class="fas fa-door-open me-2"></i>Enter Community
                            </a>
                            <a href="{{ route('community.leave', $dorm) }}" class="btn-leave" onclick="return confirm('Are you sure you want to leave this community?')">
                                <i class="fas fa-sign-out-alt me-2"></i>Leave
                            </a>
                        @else
                            <a href="{{ route('community.join', $dorm) }}" class="btn-join" onclick="return confirm('Join {{ $dorm->name }} community?')">
                                <i class="fas fa-user-plus me-2"></i>Join Community
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center" style="background: white; border-radius: 20px; padding: 40px;">
                    <h5>No communities available yet</h5>
                    <p class="mb-0">Check back later for dorm communities to join.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
