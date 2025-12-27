<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Dorms - DormMate</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #0ea5e9;
            --accent: #3b82f6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1);
        }
        
        .dorm-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 24px;
        }
        
        .dorm-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.15);
        }
        
        .dorm-card-body {
            padding: 24px;
        }
        
        .rating {
            color: #fbbf24;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    {{-- Page Header + Nav (SAME AS show.blade.php) --}}
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>

    {{-- Spacer for fixed navbar --}}
    <div style="height: 120px;"></div>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary);">
                Available Dorms
            </h1>
            <p class="text-secondary">Browse and review student housing options</p>
        </div>
        
        @if($dorms->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>No dorms available at the moment
            </div>
        @else
            <div class="row">
                @foreach($dorms as $dorm)
                    <div class="col-md-6 col-lg-4">
                        <div class="dorm-card">
                            <div class="dorm-card-body">
                                <h4 class="fw-bold mb-2">{{ $dorm->name }}</h4>

                                <p class="text-secondary mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $dorm->location }}
                                </p>

                                <p class="mb-2">
                                    <i class="fas fa-door-open me-1"></i>{{ $dorm->room_count }} rooms
                                </p>

                                <div class="mb-3">
                                    @if($dorm->avg_rating)
                                        <span class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= round($dorm->avg_rating))
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="text-secondary ms-1">
                                            ({{ number_format($dorm->avg_rating, 1) }}) - {{ $dorm->review_count }} reviews
                                        </span>
                                    @else
                                        <span class="text-secondary">No reviews yet</span>
                                    @endif
                                </div>

                                <a href="{{ route('dorms.show', $dorm->id) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-eye me-2"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
