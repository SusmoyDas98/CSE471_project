<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Received Applications - DormMate</title>
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
            <i class="fas fa-inbox me-2"></i>Received Applications
        </h1>

        @if($applications->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h3 class="mt-3 text-secondary">No applications yet</h3>
                <p class="text-secondary">Applications from dorm seekers will appear here</p>
            </div>
        @else
            @foreach($applications as $application)
                <div class="application-card">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="mb-2">{{ $application->dorm_name }}</h4>
                            <p class="mb-2">
                                <i class="fas fa-user me-2 text-primary"></i>
                                <strong>Applicant:</strong> {{ $application->applicant_name }} ({{ $application->applicant_email }})
                            </p>
                            <p class="mb-2"><strong>Message:</strong></p>
                            <p class="text-secondary mb-2">{{ $application->message }}</p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($application->created_at)->diffForHumans() }}
                            </small>
                        </div>
<div class="col-md-4 text-end">
    <span class="badge rounded-pill bg-warning px-3 py-2 mb-3 d-inline-block">
        {{ ucfirst($application->status) }}
    </span>

    @if($application->status === 'pending')
        <div class="d-flex justify-content-end gap-2 mt-2">

            <form method="POST" action="{{ route('applications.approve', $application->id) }}">
                @csrf
                <button type="submit" class="btn btn-success btn-sm rounded-pill">
                    <i class="fas fa-check me-1"></i>Approve
                </button>
            </form>

            <form method="POST" action="{{ route('applications.decline', $application->id) }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                    <i class="fas fa-times me-1"></i>Decline
                </button>
            </form>

        </div>
    @endif
</div>

                    </div>
                </div>
            @endforeach
        @endif
    </div>

</body>
</html>
