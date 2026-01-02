@extends('seeker.layout')

@section('content')
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-end mb-4 mt-3">
        <a href="{{ route('seeker.vacancies.index') }}" class="btn btn-outline-primary" style="border-radius: 12px; padding: 10px 24px; font-weight: 600;">
            <i class="fas fa-arrow-left me-2"></i>Back to Browse
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Dorm Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">{{ $vacancy->room->dorm->name }}</h4>
                    <small class="text-muted">{{ $vacancy->room->dorm->city }}</small>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Room Details</h5>
                            <ul class="list-unstyled">
                                <li><strong>Room:</strong> {{ $vacancy->room->label }}</li>
                                <li><strong>Type:</strong> {{ $vacancy->room->room_type ?? 'N/A' }}</li>
                                <li><strong>Capacity:</strong> {{ $vacancy->room->capacity }} person(s)</li>
                                @if($vacancy->room->size_sqft)
                                    <li><strong>Size:</strong> {{ $vacancy->room->size_sqft }} sqft</li>
                                @endif
                                @if($vacancy->room->gender_policy)
                                    <li><strong>Gender Policy:</strong> {{ $vacancy->room->gender_policy }}</li>
                                @endif
                                <li><strong>Shared:</strong> {{ $vacancy->room->is_shared ? 'Yes' : 'No' }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Pricing</h5>
                            @if($vacancy->room->price)
                                <p class="h4 text-primary mb-0">TK {{ number_format($vacancy->room->price) }}/month</p>
                            @else
                                <p class="text-muted">Price not specified</p>
                            @endif
                        </div>
                    </div>

                    @if($vacancy->room->dorm->description)
                        <div class="mb-3">
                            <h5>Description</h5>
                            <p>{{ $vacancy->room->dorm->description }}</p>
                        </div>
                    @endif

                    @if($vacancy->room->dorm->amenities && count($vacancy->room->dorm->amenities) > 0)
                        <div class="mb-3">
                            <h5>Amenities</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($vacancy->room->dorm->amenities as $amenity)
                                    <span class="badge bg-secondary">{{ $amenity }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <h5>Contact Information</h5>
                        @if($vacancy->room->dorm->contact_phone)
                            <p class="mb-1"><strong>Phone:</strong> {{ $vacancy->room->dorm->contact_phone }}</p>
                        @endif
                        @if($vacancy->room->dorm->contact_email)
                            <p class="mb-0"><strong>Email:</strong> {{ $vacancy->room->dorm->contact_email }}</p>
                        @endif
                    </div>

                    @if($vacancy->available_from)
                        <div class="alert alert-info mb-0">
                            <strong>Available from:</strong> {{ $vacancy->available_from->format('F d, Y') }}
                        </div>
                    @endif
                </div>
            </div>

            @if($vacancy->notes)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Additional Notes</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $vacancy->notes }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <!-- Application Form -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Apply for This Room</h5>
                </div>
                <div class="card-body">
                    @if($hasApplied)
                        @if($userApplication->status === 'accepted')
                            <div class="alert alert-success border-0">
                                <h6 class="alert-heading mb-2">🎉 Congratulations! You've Been Selected!</h6>
                                <p class="mb-2"><strong>The dorm owner has accepted your application for this room.</strong></p>
                                <p class="mb-3 small">Check your application details for contact information and next steps.</p>
                                <a href="{{ route('seeker.applications.show', $userApplication) }}" class="btn btn-success btn-sm">
                                    View Application Details →
                                </a>
                            </div>
                        @elseif($userApplication->status === 'rejected')
                            <div class="alert alert-danger border-0">
                                <h6 class="alert-heading mb-2">✗ Application Not Selected</h6>
                                <p class="mb-2"><strong>Unfortunately, your application was not selected for this vacancy.</strong></p>
                                <p class="mb-3 small">Don't give up! Keep applying to other available dorms.</p>
                                <a href="{{ route('seeker.applications.show', $userApplication) }}" class="btn btn-outline-danger btn-sm">
                                    View Details
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <strong>You have already applied for this vacancy!</strong>
                                <p class="mb-2">Your application status: 
                                    <span class="badge 
                                        @if($userApplication->status === 'waitlisted') bg-warning
                                        @else bg-info
                                        @endif">
                                        {{ ucfirst($userApplication->status) }}
                                    </span>
                                </p>
                                <a href="{{ route('seeker.applications.show', $userApplication) }}" class="btn btn-sm btn-outline-primary">
                                    View Application Details
                                </a>
                            </div>
                        @endif
                    @else
                        <form method="POST" action="{{ route('vacancies.apply', $vacancy) }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Your Message to Owner</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                                          rows="4" placeholder="Tell the owner why you're interested in this room...">{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Your Budget (per month)</label>
                                <input type="number" name="budget" class="form-control @error('budget') is-invalid @enderror" 
                                       placeholder="e.g., 5000 (in TK)" value="{{ old('budget') }}" min="0">
                                @error('budget')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">Optional - helps the owner understand your budget (in Bangladeshi Taka)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Preferred Move-in Date</label>
                                <input type="date" name="move_in_date" class="form-control @error('move_in_date') is-invalid @enderror" 
                                       value="{{ old('move_in_date') }}" min="{{ date('Y-m-d') }}">
                                @error('move_in_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">Optional - when you'd like to move in</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Submit Application
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

