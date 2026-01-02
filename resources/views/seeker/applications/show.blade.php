@extends('seeker.layout')

@section('content')
<style>
    .hero-section {
        padding: 40px 0 30px;
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
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 20px;
    }
    
    .status-banner {
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .status-banner.accepted {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
        border: 2px solid var(--success);
    }
    
    .status-banner.rejected {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(185, 28, 28, 0.1));
        border: 2px solid #dc3545;
    }
    
    .detail-card {
        background: white;
        border-radius: 20px;
        padding: 0;
        border: 2px solid rgba(14, 165, 233, 0.1);
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        overflow: hidden;
    }
    
    .detail-card.accepted {
        border-color: var(--success);
    }
    
    .detail-card.rejected {
        border-color: #dc3545;
    }
    
    .detail-header {
        padding: 25px 30px;
        color: white;
    }
    
    .detail-header.accepted {
        background: linear-gradient(135deg, var(--success), #059669);
    }
    
    .detail-header.rejected {
        background: linear-gradient(135deg, #dc3545, #b91c1c);
    }
    
    .detail-body {
        padding: 30px;
    }
    
    .sidebar-card {
        background: white;
        border-radius: 20px;
        padding: 0;
        border: 2px solid rgba(14, 165, 233, 0.1);
        margin-bottom: 25px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        overflow: hidden;
    }
    
    .sidebar-header {
        padding: 20px 25px;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(59, 130, 246, 0.1));
        border-bottom: 2px solid rgba(14, 165, 233, 0.1);
    }
    
    .sidebar-body {
        padding: 25px;
    }
    
    .btn-back {
        background: white;
        color: var(--text-secondary);
        border: 2px solid rgba(14, 165, 233, 0.2);
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        border-color: var(--primary);
        background: rgba(14, 165, 233, 0.05);
    }
    
    .btn-modern {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
        margin-bottom: 10px;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
    }
    
    .btn-outline-modern {
        background: white;
        color: var(--text-secondary);
        border: 2px solid rgba(14, 165, 233, 0.2);
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        width: 100%;
        display: block;
        text-align: center;
    }
    
    .btn-outline-modern:hover {
        border-color: var(--primary);
        background: rgba(14, 165, 233, 0.05);
    }
    
    .info-box {
        background: rgba(14, 165, 233, 0.05);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid rgba(14, 165, 233, 0.1);
    }
    
    .contact-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .contact-link:hover {
        color: var(--accent);
        text-decoration: underline;
    }
</style>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-file-alt me-2"></i>Application Details</span>
        <h1 class="hero-title">Application Status</h1>
    </div>
</div>

<div class="container mb-5">
    <div class="mb-4">
        <a href="{{ route('seeker.applications.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to My Applications
        </a>
    </div>

    @php
        $isRecentUpdate = ($application->status === 'accepted' || $application->status === 'rejected') 
                          && $application->updated_at > now()->subDays(7) 
                          && $application->updated_at != $application->created_at;
    @endphp

    @if($isRecentUpdate)
        <div class="alert alert-info border-0 shadow-sm mb-4" style="border-radius: 16px;">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-bell fa-2x"></i>
                </div>
                <div>
                    <h6 class="alert-heading mb-1">Status Updated!</h6>
                    <p class="mb-0">The dorm owner has updated your application status. This update was made {{ $application->updated_at->diffForHumans() }}.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Status Banner -->
            @if($application->status === 'accepted')
                <div class="status-banner accepted">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <i class="fas fa-party-horn fa-3x" style="color: var(--success);"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="mb-2" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
                                Congratulations! You've Been Selected!
                            </h3>
                            <p class="mb-2"><strong>The dorm owner has accepted your application for {{ $application->vacancy->room->dorm->name }}.</strong></p>
                            <p class="mb-0">Contact the dorm owner below to proceed with finalizing your stay.</p>
                        </div>
                    </div>
                </div>
            @elseif($application->status === 'rejected')
                <div class="status-banner rejected">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <i class="fas fa-times-circle fa-3x" style="color: #dc3545;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="mb-2" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
                                Application Not Selected
                            </h3>
                            <p class="mb-1"><strong>Unfortunately, your application was not selected for this vacancy.</strong></p>
                            <p class="mb-0">Don't give up! Keep applying to other available dorms.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Application Information -->
            <div class="detail-card {{ $application->status === 'accepted' ? 'accepted' : ($application->status === 'rejected' ? 'rejected' : '') }}">
                <div class="detail-header {{ $application->status === 'accepted' ? 'accepted' : ($application->status === 'rejected' ? 'rejected' : 'bg-primary') }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="mb-2" style="font-family: 'Playfair Display', serif;">Application Details</h4>
                            <small class="opacity-75">
                                <i class="fas fa-calendar me-1"></i>Applied on {{ $application->created_at->format('F d, Y \a\t g:i A') }}
                            </small>
                            @if($application->updated_at != $application->created_at)
                                <br><small class="opacity-75">
                                    <i class="fas fa-sync-alt me-1"></i>Status updated: {{ $application->updated_at->format('F d, Y \a\t g:i A') }}
                                </small>
                            @endif
                        </div>
                        <span class="badge bg-light text-dark fs-6 px-3 py-2">
                            @if($application->status === 'accepted')
                                <i class="fas fa-check-circle me-1"></i>SELECTED BY OWNER
                            @elseif($application->status === 'rejected')
                                <i class="fas fa-times-circle me-1"></i>REJECTED BY OWNER
                            @else
                                {{ strtoupper($application->status) }}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="detail-body">
                    <h5 class="mb-4" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
                        <i class="fas fa-home me-2 text-primary"></i>Dorm Information
                    </h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="small mb-2">
                                    <i class="fas fa-building me-2 text-muted"></i><strong>Dorm Name:</strong>
                                </div>
                                <div class="fw-bold">{{ $application->vacancy->room->dorm->name }}</div>
                            </div>
                            <div class="info-box">
                                <div class="small mb-2">
                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i><strong>Location:</strong>
                                </div>
                                <div class="fw-bold">{{ $application->vacancy->room->dorm->city }}</div>
                            </div>
                            @if($application->vacancy->room->dorm->address)
                                <div class="info-box">
                                    <div class="small mb-2">
                                        <i class="fas fa-address-card me-2 text-muted"></i><strong>Address:</strong>
                                    </div>
                                    <div class="fw-bold">{{ $application->vacancy->room->dorm->address }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box">
                                <div class="small mb-2">
                                    <i class="fas fa-door-open me-2 text-muted"></i><strong>Room:</strong>
                                </div>
                                <div class="fw-bold">{{ $application->vacancy->room->label }}</div>
                            </div>
                            <div class="info-box">
                                <div class="small mb-2">
                                    <i class="fas fa-bed me-2 text-muted"></i><strong>Type:</strong>
                                </div>
                                <div class="fw-bold">{{ $application->vacancy->room->room_type ?? 'N/A' }}</div>
                            </div>
                            <div class="info-box">
                                <div class="small mb-2">
                                    <i class="fas fa-users me-2 text-muted"></i><strong>Capacity:</strong>
                                </div>
                                <div class="fw-bold">{{ $application->vacancy->room->capacity }} person(s)</div>
                            </div>
                        </div>
                    </div>

                    @if($application->vacancy->room->price)
                        <div class="alert alert-light mb-4" style="border-radius: 12px; background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(59, 130, 246, 0.1)); border: 2px solid rgba(14, 165, 233, 0.2);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-money-bill-wave fa-2x me-3 text-primary"></i>
                                <div>
                                    <strong class="small">Monthly Price</strong>
                                    <div class="h4 mb-0" style="color: var(--primary);">TK {{ number_format($application->vacancy->room->price) }}/month</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <h5 class="mb-4 mt-5" style="font-family: 'Playfair Display', serif; color: var(--text-primary);">
                        <i class="fas fa-file-alt me-2 text-primary"></i>Your Application
                    </h5>
                    <div class="mb-4">
                        @if($application->message)
                            <div class="mb-4">
                                <strong class="small mb-2 d-block">Your Message:</strong>
                                <div class="border rounded p-4 bg-light mt-2" style="border-radius: 12px; border-color: rgba(14, 165, 233, 0.2) !important;">
                                    <p class="mb-0">{{ $application->message }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            @if($application->budget)
                                <div class="col-md-6 mb-3">
                                    <div class="info-box">
                                        <div class="small mb-2">
                                            <i class="fas fa-wallet me-2 text-muted"></i><strong>Your Budget:</strong>
                                        </div>
                                        <div class="fw-bold">TK {{ number_format($application->budget) }}/month</div>
                                    </div>
                                </div>
                            @endif
                            @if($application->move_in_date)
                                <div class="col-md-6 mb-3">
                                    <div class="info-box">
                                        <div class="small mb-2">
                                            <i class="fas fa-calendar-check me-2 text-muted"></i><strong>Move-in Date:</strong>
                                        </div>
                                        <div class="fw-bold">{{ $application->move_in_date->format('F d, Y') }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($application->status === 'accepted')
                        <div class="alert alert-success border-0" style="border-radius: 16px; background: rgba(16, 185, 129, 0.1); border: 2px solid var(--success) !important;">
                            <h5 class="alert-heading mb-3">
                                <i class="fas fa-check-circle me-2"></i>You've Been Selected by the Owner!
                            </h5>
                            <p class="mb-3"><strong>Great news! The dorm owner has selected you to stay in this room.</strong></p>
                            <div class="bg-white p-4 rounded mb-3" style="border-radius: 12px;">
                                <h6 class="mb-3 fw-bold">Next Steps:</h6>
                                <ol class="mb-0">
                                    <li class="mb-2">Contact the dorm owner using the contact information provided</li>
                                    <li class="mb-2">Discuss move-in details and any additional requirements</li>
                                    <li>Finalize the agreement and prepare for your stay</li>
                                </ol>
                            </div>
                            @if($application->vacancy->room->dorm->contact_phone || $application->vacancy->room->dorm->contact_email)
                                <div class="bg-white p-3 rounded" style="border-radius: 12px;">
                                    @if($application->vacancy->room->dorm->contact_phone)
                                        <p class="mb-2">
                                            <strong><i class="fas fa-phone me-2"></i>Phone:</strong><br>
                                            <a href="tel:{{ $application->vacancy->room->dorm->contact_phone }}" class="contact-link">
                                                {{ $application->vacancy->room->dorm->contact_phone }}
                                            </a>
                                        </p>
                                    @endif
                                    @if($application->vacancy->room->dorm->contact_email)
                                        <p class="mb-0">
                                            <strong><i class="fas fa-envelope me-2"></i>Email:</strong><br>
                                            <a href="mailto:{{ $application->vacancy->room->dorm->contact_email }}" class="contact-link">
                                                {{ $application->vacancy->room->dorm->contact_email }}
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @elseif($application->status === 'rejected')
                        <div class="alert alert-danger border-0" style="border-radius: 16px; background: rgba(220, 53, 69, 0.1); border: 2px solid #dc3545 !important;">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class="fas fa-times-circle fa-2x"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="alert-heading mb-3">Application Rejected by Dorm Owner</h5>
                                    <p class="mb-3"><strong>The dorm owner has reviewed your application and decided not to select you for this vacancy.</strong></p>
                                    
                                    @if($application->owner_notes)
                                        <div class="bg-white p-4 rounded mb-3" style="border-radius: 12px;">
                                            <h6 class="mb-2 fw-bold"><i class="fas fa-comment me-2"></i>Owner's Feedback:</h6>
                                            <p class="mb-0">{{ $application->owner_notes }}</p>
                                        </div>
                                    @else
                                        <div class="bg-white p-3 rounded mb-3" style="border-radius: 12px;">
                                            <p class="mb-0 text-muted">No specific feedback was provided by the dorm owner.</p>
                                        </div>
                                    @endif

                                    <div class="bg-warning bg-opacity-10 p-4 rounded" style="border-radius: 12px;">
                                        <h6 class="mb-2 fw-bold"><i class="fas fa-lightbulb me-2"></i>What's Next?</h6>
                                        <ul class="mb-0">
                                            <li class="mb-1">Don't be discouraged - this is just one opportunity</li>
                                            <li class="mb-1">Review other available dorms and apply to those that match your preferences</li>
                                            <li class="mb-1">Consider updating your profile to improve your chances</li>
                                            <li>Keep applying - persistence pays off!</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($application->status === 'waitlisted')
                        <div class="alert alert-warning border-0" style="border-radius: 16px;">
                            <h5><i class="fas fa-pause-circle me-2"></i>You're on the Waitlist</h5>
                            <p class="mb-0">Your application has been added to the waitlist. The dorm owner will contact you if a spot becomes available.</p>
                        </div>
                    @else
                        <div class="alert alert-info border-0" style="border-radius: 16px; background: rgba(14, 165, 233, 0.1); border: 2px solid var(--primary) !important;">
                            <h5><i class="fas fa-clock me-2"></i>Application Under Review</h5>
                            <p class="mb-0">The dorm owner is currently reviewing your application. You'll be notified when a decision is made. Please check back later for updates.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="sidebar-body">
                    <a href="{{ route('seeker.vacancies.show', $application->vacancy) }}" class="btn-outline-modern mb-3">
                        <i class="fas fa-eye me-2"></i>View Vacancy Details
                    </a>
                    <a href="{{ route('seeker.vacancies.index') }}" class="btn-outline-modern">
                        <i class="fas fa-search me-2"></i>Browse More Dorms
                    </a>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-address-book me-2"></i>Contact Dorm Owner</h5>
                </div>
                <div class="sidebar-body">
                    @if($application->vacancy->room->dorm->contact_phone)
                        <div class="mb-4">
                            <strong class="small d-block mb-2">
                                <i class="fas fa-phone me-2 text-primary"></i>Phone:
                            </strong>
                            <a href="tel:{{ $application->vacancy->room->dorm->contact_phone }}" class="contact-link fs-5">
                                {{ $application->vacancy->room->dorm->contact_phone }}
                            </a>
                        </div>
                    @endif
                    @if($application->vacancy->room->dorm->contact_email)
                        <div>
                            <strong class="small d-block mb-2">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email:
                            </strong>
                            <a href="mailto:{{ $application->vacancy->room->dorm->contact_email }}" class="contact-link">
                                {{ $application->vacancy->room->dorm->contact_email }}
                            </a>
                        </div>
                    @endif
                    @if(!$application->vacancy->room->dorm->contact_phone && !$application->vacancy->room->dorm->contact_email)
                        <p class="text-muted mb-0">Contact information not available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
