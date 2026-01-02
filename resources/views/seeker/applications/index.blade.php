@extends('seeker.layout')

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
    
    .filter-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
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
    
    .application-card.accepted {
        border-color: var(--success);
    }
    
    .application-card.rejected {
        border-color: #dc3545;
    }
    
    .application-header {
        padding: 20px 25px;
        color: white;
    }
    
    .application-header.accepted {
        background: linear-gradient(135deg, var(--success), #059669);
    }
    
    .application-header.rejected {
        background: linear-gradient(135deg, #dc3545, #b91c1c);
    }
    
    .application-body {
        padding: 25px;
    }
    
    .btn-modern {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
    }
    
    .btn-outline-modern {
        background: white;
        color: var(--text-secondary);
        border: 2px solid rgba(14, 165, 233, 0.2);
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-outline-modern:hover {
        border-color: var(--primary);
        background: rgba(14, 165, 233, 0.05);
    }
    
    .notification-card {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 2px solid #fbbf24;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(251, 191, 36, 0.2);
    }
    
    .notification-card.warning {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-color: #dc3545;
        box-shadow: 0 4px 20px rgba(220, 53, 69, 0.2);
    }
    
    .notification-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #dc3545;
    }
</style>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-file-alt me-2"></i>Track Applications</span>
        <h1 class="hero-title">My Applications</h1>
        <p class="text-muted">Track your dorm room applications</p>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-end mb-4">
        <div class="d-flex gap-2">
            <a href="{{ route('seeker.dashboard') }}" class="btn-outline-modern">Dashboard</a>
            <a href="{{ route('seeker.vacancies.index') }}" class="btn-modern">Browse More Dorms</a>
        </div>
    </div>

    <!-- Room Deletion Notifications -->
    @if(isset($roomDeletedNotifications) && $roomDeletedNotifications->count() > 0)
        <div class="notification-card warning">
            <div class="d-flex align-items-start gap-3">
                <div class="notification-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-3 fw-bold text-dark">
                        <i class="fas fa-bell me-2"></i>Important Notifications
                    </h5>
                    @foreach($roomDeletedNotifications as $notification)
                        <div class="mb-3 p-3 bg-white rounded border border-danger" style="border-radius: 12px;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 fw-bold text-danger">
                                    <i class="fas fa-trash-alt me-2"></i>{{ $notification->title }}
                                </h6>
                                <form method="POST" action="{{ route('notifications.mark-read', $notification) }}" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-link text-muted p-0" title="Mark as read">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                            <p class="mb-0 text-dark">{{ $notification->message }}</p>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Filter by Status -->
    <div class="filter-card">
        <form method="GET" action="{{ route('seeker.applications.index') }}" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label fw-bold">Filter by Status</label>
                <select name="status" class="form-select" onchange="this.form.submit()" style="border-radius: 12px; border: 2px solid rgba(14, 165, 233, 0.2); padding: 12px;">
                    <option value="">All Applications</option>
                    <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="reviewing" {{ request('status') === 'reviewing' ? 'selected' : '' }}>Under Review</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="waitlisted" {{ request('status') === 'waitlisted' ? 'selected' : '' }}>Waitlisted</option>
                </select>
            </div>
            @if(request('status'))
                <div class="col-md-6">
                    <a href="{{ route('seeker.applications.index') }}" class="btn btn-outline-secondary">Clear Filter</a>
                </div>
            @endif
        </form>
    </div>

    @if($applications->isEmpty())
        <div class="alert alert-info text-center" style="background: white; border-radius: 20px; padding: 50px; border: 2px solid rgba(14, 165, 233, 0.2);">
            <i class="fas fa-inbox fa-3x mb-3 text-primary"></i>
            <h5>No applications yet</h5>
            <p class="mb-3">You haven't applied for any dorm rooms yet.</p>
            <a href="{{ route('seeker.vacancies.index') }}" class="btn-modern">Browse Available Dorms</a>
        </div>
    @else
        @php
            $acceptedCount = $applications->where('status', 'accepted')->count();
            $rejectedCount = $applications->where('status', 'rejected')->count();
            $recentAccepted = $applications->filter(function($app) {
                return $app->status === 'accepted' && $app->updated_at > now()->subDays(7);
            })->count();
        @endphp
        
        @if($recentAccepted > 0)
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 16px; border: 2px solid var(--success);">
                <h5 class="alert-heading">
                    <i class="fas fa-party-horn me-2"></i>Great News! You have {{ $acceptedCount }} accepted application(s)!
                </h5>
                <p class="mb-0">Check your applications below to see which dorm rooms you've been selected for.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @foreach($applications as $application)
                @php
                    $isRecentUpdate = ($application->status === 'accepted' || $application->status === 'rejected') 
                                        && $application->updated_at > now()->subDays(7);
                @endphp
                <div class="col-md-6 mb-4">
                    <div class="application-card {{ $application->status === 'accepted' ? 'accepted' : ($application->status === 'rejected' ? 'rejected' : '') }}">
                        <div class="application-header {{ $application->status === 'accepted' ? 'accepted' : ($application->status === 'rejected' ? 'rejected' : 'bg-primary') }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h5 class="mb-0 fw-bold">{{ $application->vacancy->room->dorm->name }}</h5>
                                        @if($isRecentUpdate)
                                            <span class="badge bg-warning text-dark animate-pulse">NEW</span>
                                        @endif
                                    </div>
                                    <small class="opacity-75">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $application->vacancy->room->dorm->city }}
                                    </small>
                                </div>
                                <span class="badge bg-light text-dark fs-6 px-3 py-2">
                                    @if($application->status === 'accepted')
                                        <i class="fas fa-check-circle me-1"></i>SELECTED
                                    @elseif($application->status === 'rejected')
                                        <i class="fas fa-times-circle me-1"></i>REJECTED
                                    @else
                                        {{ strtoupper($application->status) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="application-body">
                            <div class="mb-3">
                                <div class="small mb-2">
                                    <i class="fas fa-door-open me-2 text-muted"></i><strong>Room:</strong> {{ $application->vacancy->room->label }}
                                </div>
                                @if($application->vacancy->room->price)
                                    <div class="small mb-2">
                                        <i class="fas fa-money-bill-wave me-2 text-muted"></i><strong>Price:</strong> TK {{ number_format($application->vacancy->room->price) }}/month
                                    </div>
                                @endif
                                @if($application->move_in_date)
                                    <div class="small mb-2">
                                        <i class="fas fa-calendar me-2 text-muted"></i><strong>Move-in Date:</strong> {{ $application->move_in_date->format('M d, Y') }}
                                    </div>
                                @endif
                                <div class="small">
                                    <i class="fas fa-clock me-2 text-muted"></i><strong>Applied:</strong> {{ $application->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            @if($application->message)
                                <div class="mb-3 border-top pt-3">
                                    <strong class="small">Your Message:</strong>
                                    <p class="small mb-0 text-muted mt-1">{{ \Illuminate\Support\Str::limit($application->message, 150) }}</p>
                                </div>
                            @endif

                            @if($application->status === 'accepted')
                                <div class="alert alert-success mb-3 border-0" style="border-radius: 12px; background: rgba(16, 185, 129, 0.1);">
                                    <h6 class="alert-heading mb-2">
                                        <i class="fas fa-check-circle me-2"></i>Congratulations! You've Been Selected!
                                    </h6>
                                    <p class="mb-0 small">The dorm owner has accepted your application. Contact them to finalize your stay.</p>
                                </div>
                            @elseif($application->status === 'rejected')
                                <div class="alert alert-danger mb-3 border-0" style="border-radius: 12px; background: rgba(220, 53, 69, 0.1);">
                                    <h6 class="alert-heading mb-2">
                                        <i class="fas fa-times-circle me-2"></i>Application Rejected
                                    </h6>
                                    @if($application->owner_notes)
                                        <div class="mt-2 p-3 bg-white rounded border" style="border-radius: 8px;">
                                            <strong class="small"><i class="fas fa-comment me-1"></i>Owner's Feedback:</strong>
                                            <p class="mb-0 small mt-1">{{ $application->owner_notes }}</p>
                                        </div>
                                    @else
                                        <p class="mb-0 small">No specific feedback provided.</p>
                                    @endif
                                </div>
                            @elseif($application->status === 'waitlisted')
                                <div class="alert alert-warning mb-3 border-0" style="border-radius: 12px;">
                                    <strong><i class="fas fa-pause-circle me-2"></i>Waitlisted</strong> - You're on the waitlist. The owner will contact you if a spot becomes available.
                                </div>
                            @else
                                <div class="alert alert-info mb-3 border-0" style="border-radius: 12px; background: rgba(14, 165, 233, 0.1);">
                                    <strong><i class="fas fa-clock me-2"></i>Under Review</strong> - The dorm owner is reviewing your application. You'll be notified when a decision is made.
                                </div>
                            @endif
                            
                            <a href="{{ route('seeker.applications.show', $application) }}" class="btn btn-outline-primary w-100" style="border-radius: 12px;">
                                <i class="fas fa-eye me-2"></i>View Details
                            </a>
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
