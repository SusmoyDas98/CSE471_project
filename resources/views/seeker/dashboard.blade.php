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
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 2px solid rgba(14, 165, 233, 0.1);
        transition: all 0.3s;
        height: 100%;
        border-left: 4px solid var(--primary);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 36px rgba(14, 165, 233, 0.15);
    }
    
    .stat-card.success {
        border-left-color: var(--success);
    }
    
    .stat-card.danger {
        border-left-color: #dc3545;
    }
    
    .stat-card.warning {
        border-left-color: var(--gold);
    }
    
    .content-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 2px solid rgba(14, 165, 233, 0.1);
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
    }
    
    .application-card {
        background: rgba(14, 165, 233, 0.05);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 15px;
        border: 2px solid rgba(14, 165, 233, 0.1);
        transition: all 0.3s;
    }
    
    .application-card:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.1);
    }
    
    .quick-action-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 2px solid rgba(14, 165, 233, 0.1);
        transition: all 0.3s;
        height: 100%;
        text-align: center;
    }
    
    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 36px rgba(14, 165, 233, 0.15);
        border-color: var(--primary);
    }
    
    .btn-modern {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
    }
</style>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Overview</span>
        <h1 class="hero-title">My Dashboard</h1>
        <p class="text-muted">Overview of your dorm applications and status updates</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <h6 class="text-muted mb-2"><i class="fas fa-file-alt me-2"></i>Total Applications</h6>
                <h3 class="mb-0" style="color: var(--primary); font-weight: 700;">{{ $stats['total'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card success">
                <h6 class="text-muted mb-2"><i class="fas fa-check-circle me-2"></i>Accepted</h6>
                <h3 class="mb-0" style="color: var(--success); font-weight: 700;">{{ $stats['accepted'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card danger">
                <h6 class="text-muted mb-2"><i class="fas fa-times-circle me-2"></i>Rejected</h6>
                <h3 class="mb-0" style="color: #dc3545; font-weight: 700;">{{ $stats['rejected'] }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card warning">
                <h6 class="text-muted mb-2"><i class="fas fa-clock me-2"></i>Pending Review</h6>
                <h3 class="mb-0" style="color: var(--gold); font-weight: 700;">{{ $stats['pending'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Recent Rejections -->
    @if($recentRejections->isNotEmpty())
        <div class="content-card border-danger border-2">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 style="font-family: 'Playfair Display', serif; color: #dc3545;">
                        <i class="fas fa-times-circle me-2"></i>Recent Rejections
                    </h4>
                    <small class="text-muted">Applications rejected by dorm owners in the last 7 days</small>
                </div>
                <span class="badge bg-danger fs-6 animate-pulse">{{ $recentRejections->count() }} NEW</span>
            </div>
            <div class="alert alert-danger border-0 mb-3" style="border-radius: 12px;">
                <h6 class="alert-heading mb-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>You have {{ $recentRejections->count() }} application(s) that were recently rejected
                </h6>
                <p class="mb-0">Don't worry! Check the details below and keep applying to other available dorms. There are many opportunities waiting for you.</p>
            </div>

            <div class="row">
                @foreach($recentRejections as $application)
                    <div class="col-md-6 mb-3">
                        <div class="application-card border-danger">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $application->vacancy->room->dorm->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $application->vacancy->room->dorm->city }} • {{ $application->vacancy->room->label }}
                                    </small>
                                </div>
                                <span class="badge bg-danger">REJECTED</span>
                            </div>
                            <div class="mb-2 small">
                                <strong>Rejected:</strong> {{ $application->updated_at->diffForHumans() }}<br>
                                <strong>Applied:</strong> {{ $application->created_at->format('M d, Y') }}
                            </div>
                            @if($application->owner_notes)
                                <div class="alert alert-light border mb-2" style="border-radius: 8px;">
                                    <strong><i class="fas fa-comment me-1"></i>Owner's Feedback:</strong>
                                    <p class="mb-0 small mt-1">{{ $application->owner_notes }}</p>
                                </div>
                            @else
                                <p class="text-muted small mb-0">No specific feedback provided by the owner.</p>
                            @endif
                            <a href="{{ route('seeker.applications.show', $application) }}" class="btn btn-sm btn-outline-danger w-100 mt-2">
                                <i class="fas fa-eye me-1"></i>View Full Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('seeker.applications.index', ['status' => 'rejected']) }}" class="btn btn-outline-danger">
                    View All Rejected Applications <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Recent Acceptances -->
    @if($recentAcceptances->isNotEmpty())
        <div class="content-card border-success border-2">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 style="font-family: 'Playfair Display', serif; color: var(--success);">
                        <i class="fas fa-check-circle me-2"></i>Recent Acceptances
                    </h4>
                    <small class="text-muted">Applications accepted by dorm owners in the last 7 days</small>
                </div>
                <span class="badge bg-success fs-6">{{ $recentAcceptances->count() }} NEW</span>
            </div>
            <div class="alert alert-success border-0 mb-3" style="border-radius: 12px;">
                <h6 class="alert-heading mb-2">
                    <i class="fas fa-party-horn me-2"></i>Congratulations! You have {{ $recentAcceptances->count() }} application(s) that were recently accepted!
                </h6>
                <p class="mb-0">Contact the dorm owners to proceed with finalizing your stay.</p>
            </div>

            <div class="row">
                @foreach($recentAcceptances as $application)
                    <div class="col-md-6 mb-3">
                        <div class="application-card border-success">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $application->vacancy->room->dorm->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $application->vacancy->room->dorm->city }} • {{ $application->vacancy->room->label }}
                                    </small>
                                </div>
                                <span class="badge bg-success">ACCEPTED</span>
                            </div>
                            <div class="mb-2 small">
                                <strong>Accepted:</strong> {{ $application->updated_at->diffForHumans() }}<br>
                                @if($application->vacancy->room->dorm->contact_phone)
                                    <strong><i class="fas fa-phone me-1"></i>Phone:</strong> {{ $application->vacancy->room->dorm->contact_phone }}<br>
                                @endif
                                @if($application->vacancy->room->dorm->contact_email)
                                    <strong><i class="fas fa-envelope me-1"></i>Email:</strong> {{ $application->vacancy->room->dorm->contact_email }}
                                @endif
                            </div>
                            <a href="{{ route('seeker.applications.show', $application) }}" class="btn btn-sm btn-success w-100 mt-2">
                                <i class="fas fa-eye me-1"></i>View Details & Contact Owner
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('seeker.applications.index', ['status' => 'accepted']) }}" class="btn btn-outline-success">
                    View All Accepted Applications <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Pending Applications -->
    @if($pendingApplications->isNotEmpty())
        <div class="content-card">
            <h4 style="font-family: 'Playfair Display', serif; color: var(--text-primary); margin-bottom: 15px;">
                <i class="fas fa-clock me-2"></i>Pending Applications
            </h4>
            <small class="text-muted mb-3 d-block">Applications currently under review by dorm owners</small>
            <div class="row">
                @foreach($pendingApplications as $application)
                    <div class="col-md-6 mb-3">
                        <div class="application-card border-info">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $application->vacancy->room->dorm->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $application->vacancy->room->dorm->city }}
                                    </small>
                                </div>
                                <span class="badge bg-info">{{ strtoupper($application->status) }}</span>
                            </div>
                            <p class="mb-0 small">The dorm owner is reviewing your application. You'll be notified when a decision is made.</p>
                            <a href="{{ route('seeker.applications.show', $application) }}" class="btn btn-sm btn-outline-info w-100 mt-2">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('seeker.applications.index') }}" class="btn btn-outline-primary">
                    View All Applications <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="quick-action-card">
                <i class="fas fa-building fa-3x mb-3" style="color: var(--primary);"></i>
                <h5 class="mb-2">Browse Available Dorms</h5>
                <p class="text-muted small mb-3">Find and apply for available dorm rooms</p>
                <a href="{{ route('seeker.vacancies.index') }}" class="btn-modern">
                    <i class="fas fa-search me-2"></i>Browse Dorms
                </a>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="quick-action-card">
                <i class="fas fa-users fa-3x mb-3" style="color: var(--success);"></i>
                <h5 class="mb-2">Find Roommates</h5>
                <p class="text-muted small mb-3">View other seekers' preferences to find compatible roommates</p>
                <a href="{{ route('seeker.profiles.index') }}" class="btn-modern" style="background: linear-gradient(135deg, var(--success), #059669);">
                    <i class="fas fa-user-plus me-2"></i>Find Roommates
                </a>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="quick-action-card">
                <i class="fas fa-file-alt fa-3x mb-3" style="color: var(--accent);"></i>
                <h5 class="mb-2">View All Applications</h5>
                <p class="text-muted small mb-3">Track all your application statuses</p>
                <a href="{{ route('seeker.applications.index') }}" class="btn-outline-primary btn w-100">
                    <i class="fas fa-list me-2"></i>My Applications
                </a>
            </div>
        </div>
    </div>

    @if($stats['total'] === 0)
        <div class="content-card text-center">
            <i class="fas fa-rocket fa-3x mb-3 text-primary"></i>
            <h4 style="font-family: 'Playfair Display', serif; color: var(--text-primary);">Welcome to DormMate!</h4>
            <p class="mb-3">You haven't applied for any dorm rooms yet.</p>
            <a href="{{ route('seeker.vacancies.index') }}" class="btn-modern">
                <i class="fas fa-search me-2"></i>Start Browsing Available Dorms
            </a>
        </div>
    @endif
</div>
@endsection
