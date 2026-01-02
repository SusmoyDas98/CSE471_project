@extends('owner.layout')

@section('content')
<style>
    .hero-section {
        padding: 40px 0 40px;
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
        font-size: 3rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 20px;
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
    
    .stat-card.purple {
        border-left: 4px solid #8b5cf6;
    }
    
    .stat-card.warning {
        border-left: 4px solid var(--gold);
    }
    
    .stat-card.info {
        border-left: 4px solid var(--secondary);
    }
    
    .stat-card.success {
        border-left: 4px solid var(--success);
    }
    
    .filter-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 2px solid rgba(14, 165, 233, 0.1);
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
    }
    
    .application-card {
        background: white;
        border-radius: 20px;
        padding: 0;
        border: 2px solid rgba(14, 165, 233, 0.1);
        margin-bottom: 25px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        transition: all 0.3s;
        overflow: hidden;
    }
    
    .application-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.15);
    }
    
    .application-header {
        padding: 20px 25px;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(59, 130, 246, 0.1));
        border-bottom: 2px solid rgba(14, 165, 233, 0.1);
    }
    
    .application-body {
        padding: 25px;
    }
    
    .application-footer {
        padding: 20px 25px;
        background: rgba(14, 165, 233, 0.03);
        border-top: 1px solid rgba(14, 165, 233, 0.1);
    }
    
    .btn-modern {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 0.9rem;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
    }
    
    .btn-success-modern {
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 0.9rem;
    }
    
    .btn-success-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }
    
    .btn-outline-danger-modern {
        background: white;
        color: #dc3545;
        border: 2px solid #dc3545;
        padding: 8px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 0.9rem;
    }
    
    .btn-outline-danger-modern:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
    }
    
    .info-box {
        background: rgba(14, 165, 233, 0.05);
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid rgba(14, 165, 233, 0.1);
    }
</style>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-clipboard-check me-2"></i>Review Applications</span>
        <h1 class="hero-title">Application Reviews</h1>
        <p class="text-muted">Review applications from dorm seekers and select which seekers can stay in your dorm</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card purple">
                <h6 class="text-muted mb-2"><i class="fas fa-file-alt me-2"></i>Total Applications</h6>
                <h3 class="mb-0" style="color: #8b5cf6; font-weight: 700;">{{ $stats['total'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card warning">
                <h6 class="text-muted mb-2"><i class="fas fa-clock me-2"></i>Pending Review</h6>
                <h3 class="mb-0" style="color: var(--gold); font-weight: 700;">{{ $stats['pending'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card info">
                <h6 class="text-muted mb-2"><i class="fas fa-eye me-2"></i>Under Review</h6>
                <h3 class="mb-0" style="color: var(--secondary); font-weight: 700;">{{ $stats['reviewing'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card success">
                <h6 class="text-muted mb-2"><i class="fas fa-check-circle me-2"></i>Accepted</h6>
                <h3 class="mb-0" style="color: var(--success); font-weight: 700;">{{ $stats['accepted'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <form method="GET" action="{{ route('owner.applications.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Filter by Status</label>
                <select name="status" class="form-select" style="border-radius: 12px; border: 2px solid rgba(14, 165, 233, 0.2); padding: 12px;">
                    <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                    <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="reviewing" {{ request('status') === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="waitlisted" {{ request('status') === 'waitlisted' ? 'selected' : '' }}>Waitlisted</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Filter by Dorm</label>
                <select name="dorm_id" class="form-select" style="border-radius: 12px; border: 2px solid rgba(14, 165, 233, 0.2); padding: 12px;">
                    <option value="">All Dorms</option>
                    @foreach($dorms as $dorm)
                        <option value="{{ $dorm->id }}" {{ request('dorm_id') == $dorm->id ? 'selected' : '' }}>
                            {{ $dorm->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn-modern me-2">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <a href="{{ route('owner.applications.index') }}" class="btn btn-outline-secondary" style="border-radius: 12px;">Clear</a>
            </div>
        </form>
    </div>

    @if($applications->isEmpty())
        <div class="alert alert-info text-center" style="background: white; border-radius: 20px; padding: 50px; border: 2px solid rgba(14, 165, 233, 0.2);">
            <i class="fas fa-inbox fa-3x mb-3 text-primary"></i>
            <h5>No applications found</h5>
            <p class="mb-0">There are no applications matching your filters. Check back later or adjust your filters.</p>
        </div>
    @else
        <div class="row">
            @foreach($applications as $application)
                <div class="col-md-6 mb-4">
                    <div class="application-card">
                        <div class="application-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
                                        <i class="fas fa-user me-2"></i>{{ $application->seeker->name ?? 'User #' . $application->user_id }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i>{{ $application->seeker->email ?? 'N/A' }}
                                    </small>
                                </div>
                                <span class="badge 
                                    @if($application->status === 'accepted') text-bg-success
                                    @elseif($application->status === 'rejected') text-bg-danger
                                    @elseif($application->status === 'waitlisted') text-bg-warning
                                    @elseif($application->status === 'reviewing') text-bg-info
                                    @else text-bg-secondary
                                    @endif px-3 py-2">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="application-body">
                            <div class="info-box mb-3">
                                <div class="small mb-2">
                                    <i class="fas fa-building me-2 text-muted"></i><strong>Dorm:</strong> {{ $application->vacancy->room->dorm->name }}
                                </div>
                                <div class="small mb-2">
                                    <i class="fas fa-door-open me-2 text-muted"></i><strong>Room:</strong> {{ $application->vacancy->room->label }}
                                </div>
                                @if($application->move_in_date)
                                    <div class="small mb-2">
                                        <i class="fas fa-calendar-check me-2 text-muted"></i><strong>Move-in Date:</strong> {{ $application->move_in_date->format('M d, Y') }}
                                    </div>
                                @endif
                                @if($application->budget)
                                    <div class="small">
                                        <i class="fas fa-money-bill-wave me-2 text-muted"></i><strong>Budget:</strong> TK {{ number_format($application->budget) }}
                                    </div>
                                @endif
                            </div>

                            @if($application->message)
                                <div class="mb-3">
                                    <strong class="small d-block mb-2"><i class="fas fa-comment me-2"></i>Message:</strong>
                                    <div class="border rounded p-3 bg-light" style="border-radius: 12px; border-color: rgba(14, 165, 233, 0.2) !important;">
                                        <p class="small mb-0">{{ \Illuminate\Support\Str::limit($application->message, 150) }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($application->seeker->detail)
                                <div class="mb-3 border-top pt-3">
                                    <strong class="small d-block mb-2"><i class="fas fa-user-circle me-2"></i>Seeker Profile:</strong>
                                    <div class="small">
                                        @if($application->seeker->detail->bio)
                                            <div class="mb-2">
                                                <strong>Bio:</strong> {{ \Illuminate\Support\Str::limit($application->seeker->detail->bio, 100) }}
                                            </div>
                                        @endif
                                        @if($application->seeker->detail->phone)
                                            <div class="mb-2">
                                                <i class="fas fa-phone me-1"></i><strong>Phone:</strong> {{ $application->seeker->detail->phone }}
                                            </div>
                                        @endif
                                        @if($application->seeker->detail->budget_min && $application->seeker->detail->budget_max)
                                            <div class="mb-2">
                                                <i class="fas fa-wallet me-1"></i><strong>Budget Range:</strong> TK {{ number_format($application->seeker->detail->budget_min) }} - TK {{ number_format($application->seeker->detail->budget_max) }}
                                            </div>
                                        @endif
                                        @if($application->seeker->detail->room_type_pref)
                                            <div class="mb-2">
                                                <i class="fas fa-home me-1"></i><strong>Prefers:</strong> {{ $application->seeker->detail->room_type_pref }}
                                            </div>
                                        @endif
                                        @if($application->seeker->detail->smoking !== null)
                                            <div>
                                                <i class="fas fa-info-circle me-1"></i><strong>Lifestyle:</strong> 
                                                Smoking: {{ $application->seeker->detail->smoking ? 'Yes' : 'No' }} | 
                                                Pet Friendly: {{ $application->seeker->detail->pet_friendly ? 'Yes' : 'No' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-light small mb-3" style="border-radius: 12px;">
                                    <i class="fas fa-info-circle me-2"></i><em>Seeker hasn't completed their profile yet.</em>
                                </div>
                            @endif

                            @if($application->owner_notes)
                                <div class="alert alert-info small mb-0" style="border-radius: 12px; background: rgba(14, 165, 233, 0.1); border: 1px solid rgba(14, 165, 233, 0.2);">
                                    <strong><i class="fas fa-sticky-note me-2"></i>Your Notes:</strong> {{ $application->owner_notes }}
                                </div>
                            @endif
                        </div>
                        <div class="application-footer">
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('owner.applications.show', $application) }}" class="btn-modern">
                                    <i class="fas fa-eye me-1"></i>Review Details
                                </a>
                                @if($application->status !== 'accepted')
                                    <form method="POST" action="{{ route('owner.applications.quickAction', $application) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="reject_others" value="1">
                                        <button type="submit" name="action" value="accept" class="btn-success-modern" 
                                                onclick="return confirm('Accept this seeker to stay in your dorm? Other applications for this vacancy will be rejected.')">
                                            <i class="fas fa-check me-1"></i>Accept to Stay
                                        </button>
                                    </form>
                                @else
                                    <span class="badge text-bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Selected to Stay
                                    </span>
                                @endif
                                @if($application->status !== 'rejected')
                                    <form method="POST" action="{{ route('owner.applications.quickAction', $application) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" name="action" value="reject" class="btn-outline-danger-modern"
                                                onclick="return confirm('Reject this application?')">
                                            <i class="fas fa-times me-1"></i>Reject
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
