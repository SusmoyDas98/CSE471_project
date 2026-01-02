<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - DormMate</title>
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
    
    .application-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.1);
        transition: all 0.3s ease;
    }
    
    .application-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.15);
    }
    
    .badge.pending {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }
    
    .badge.approved {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .badge.rejected {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
</style>
</head>
<body>

    {{-- Page Header + Nav --}}
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>

    <div style="height: 120px;"></div>

    <div class="container py-5">
        <h1 class="text-center mb-5" style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary);">
            <i class="fas fa-file-alt me-2"></i>My Applications
        </h1>

        @if($applications->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h3 class="mt-3 text-secondary">No applications yet</h3>
                <p class="text-secondary">Start browsing dorms and apply to find your perfect home!</p>
                <a href="{{ route('dorms.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-search me-2"></i>Browse Dorms
                </a>
            </div>
        @else
            @foreach($applications as $application)
                <div class="application-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h4 class="mb-1">{{ $application->dorm_name }}</h4>
                            <p class="text-secondary mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $application->location }}
                            </p>
                        </div>
                        <span class="badge {{ $application->status }} px-3 py-2">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                    
                    <p class="mb-2"><strong>Your Reference / Message:</strong></p>
                    <p class="text-secondary mb-3">{{ $application->Reference ?? '—' }}</p>

                    <p class="mb-2"><strong>Documents:</strong></p>
                    <p class="text-secondary mb-3">
                        @if($application->Student_id)
                            <a href="{{ route('applications.file', ['id' => $application->id, 'type' => 'student']) }}" target="_blank">Student ID</a>
                        @endif
                        @if($application->Government_id)
                            &nbsp;|&nbsp; <a href="{{ route('applications.file', ['id' => $application->id, 'type' => 'government']) }}" target="_blank">Government ID</a>
                        @endif
                        @if($application->Personal_photo)
                            &nbsp;|&nbsp; <a href="{{ route('applications.file', ['id' => $application->id, 'type' => 'photo']) }}" target="_blank">Photo</a>
                        @endif
                    </p>
                    
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Applied {{ \Carbon\Carbon::parse($application->created_at)->diffForHumans() }}
                    </small>
                </div>
            @endforeach
        @endif
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
