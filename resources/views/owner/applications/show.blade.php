@extends('owner.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Application Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('owner.applications.index') }}">Applications</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>
        <span class="badge 
            @if($application->status === 'accepted') text-bg-success
            @elseif($application->status === 'rejected') text-bg-danger
            @elseif($application->status === 'waitlisted') text-bg-warning
            @elseif($application->status === 'reviewing') text-bg-info
            @else text-bg-secondary
            @endif fs-6">
            {{ ucfirst($application->status) }}
        </span>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Application Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Application Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Dorm:</strong> {{ $application->vacancy->room->dorm->name }}<br>
                            <strong>Room:</strong> {{ $application->vacancy->room->label }}<br>
                            <strong>Vacancy Status:</strong> 
                            <span class="badge text-bg-info">{{ $application->vacancy->status }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Applied Date:</strong> {{ $application->created_at->format('M d, Y H:i') }}<br>
                            <strong>Move-in Date:</strong> {{ optional($application->move_in_date)->format('M d, Y') ?? 'Not specified' }}<br>
                            <strong>Budget:</strong> {{ $application->budget ? 'TK ' . number_format($application->budget) : 'Not specified' }}
                        </div>
                    </div>

                    @if($application->message)
                        <div class="mb-3">
                            <strong>Applicant's Message:</strong>
                            <div class="border rounded p-3 bg-light mt-2">
                                {{ $application->message }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Seeker Profile Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Seeker Profile & Preferences</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Name:</strong> {{ $application->seeker->name }}<br>
                            <strong>Email:</strong> {{ $application->seeker->email }}<br>
                            @if($application->seeker->detail && $application->seeker->detail->phone)
                                <strong>Phone:</strong> {{ $application->seeker->detail->phone }}<br>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($application->seeker->detail)
                                @if($application->seeker->detail->budget_min && $application->seeker->detail->budget_max)
                                    <strong>Budget Range:</strong> TK {{ number_format($application->seeker->detail->budget_min) }} - TK {{ number_format($application->seeker->detail->budget_max) }}<br>
                                @endif
                                @if($application->seeker->detail->stay_length_months)
                                    <strong>Stay Duration:</strong> {{ $application->seeker->detail->stay_length_months }} months<br>
                                @endif
                            @endif
                        </div>
                    </div>

                    @if($application->seeker->detail && $application->seeker->detail->verification_document)
                        <div class="mb-3 p-3 bg-light rounded border">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <strong><i class="fas fa-id-card text-primary me-2"></i>Verification Document</strong>
                                    <p class="mb-0 text-muted small">Student ID, University Payment Receipt, or NID</p>
                                </div>
                                <a href="{{ route('owner.applications.viewDocument', $application) }}" 
                                   target="_blank" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-external-link-alt me-1"></i>View Document
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($application->seeker->detail)
                        @if($application->seeker->detail->bio)
                            <div class="mb-3">
                                <strong>Bio:</strong>
                                <p class="mb-0">{{ $application->seeker->detail->bio }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mt-3 mb-2">Lifestyle Preferences</h6>
                                <ul class="list-unstyled small">
                                    <li><strong>Smoking:</strong> {{ $application->seeker->detail->smoking ? 'Yes' : 'No' }}</li>
                                    <li><strong>Pet Friendly:</strong> {{ $application->seeker->detail->pet_friendly ? 'Yes' : 'No' }}</li>
                                    @if($application->seeker->detail->cleanliness_level)
                                        <li><strong>Cleanliness Level:</strong> {{ $application->seeker->detail->cleanliness_level }}/5</li>
                                    @endif
                                    @if($application->seeker->detail->noise_tolerance)
                                        <li><strong>Noise Tolerance:</strong> {{ $application->seeker->detail->noise_tolerance }}/5</li>
                                    @endif
                                    @if($application->seeker->detail->wake_time)
                                        <li><strong>Wake Time:</strong> {{ \Carbon\Carbon::parse($application->seeker->detail->wake_time)->format('H:i') }}</li>
                                    @endif
                                    @if($application->seeker->detail->sleep_time)
                                        <li><strong>Sleep Time:</strong> {{ \Carbon\Carbon::parse($application->seeker->detail->sleep_time)->format('H:i') }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mt-3 mb-2">Room Preferences</h6>
                                <ul class="list-unstyled small">
                                    @if($application->seeker->detail->room_type_pref)
                                        <li><strong>Room Type:</strong> {{ $application->seeker->detail->room_type_pref }}</li>
                                    @endif
                                    @if($application->seeker->detail->gender_pref)
                                        <li><strong>Gender Preference:</strong> {{ $application->seeker->detail->gender_pref }}</li>
                                    @endif
                                    @if($application->seeker->detail->has_roommate)
                                        <li><strong>Has Roommate:</strong> Yes</li>
                                        @if($application->seeker->detail->roommate_count)
                                            <li><strong>Roommate Count:</strong> {{ $application->seeker->detail->roommate_count }}</li>
                                        @endif
                                    @else
                                        <li><strong>Has Roommate:</strong> No</li>
                                    @endif
                                    @if($application->seeker->detail->study_habits)
                                        <li><strong>Study or Work Habit:</strong> {{ $application->seeker->detail->study_habits }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        @if($application->seeker->detail->languages && count($application->seeker->detail->languages) > 0)
                            <div class="mb-2">
                                <strong>Languages:</strong> {{ implode(', ', $application->seeker->detail->languages) }}
                            </div>
                        @endif

                        @if($application->seeker->detail->interests && count($application->seeker->detail->interests) > 0)
                            <div class="mb-2">
                                <strong>Interests:</strong> {{ implode(', ', $application->seeker->detail->interests) }}
                            </div>
                        @endif

                        @if($application->seeker->detail->preferred_universities && count($application->seeker->detail->preferred_universities) > 0)
                            <div class="mb-2">
                                <strong>Preferred Universities:</strong> {{ implode(', ', $application->seeker->detail->preferred_universities) }}
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            This seeker hasn't filled out their profile preferences yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Review Actions -->
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Select Seeker to Stay</h5>
                    <small>Choose which seeker can stay in your dorm</small>
                </div>
                <div class="card-body">
                    @if($application->status === 'accepted')
                        <div class="alert alert-success">
                            <strong>✓ This seeker has been selected to stay in your dorm.</strong>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('owner.applications.updateStatus', $application) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Decision</label>
                            <select name="status" class="form-select form-select-lg @error('status') is-invalid @enderror" required>
                                <option value="submitted" {{ $application->status === 'submitted' ? 'selected' : '' }}>Submitted (Pending Review)</option>
                                <option value="reviewing" {{ $application->status === 'reviewing' ? 'selected' : '' }}>Under Review</option>
                                <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>✓ Accept - Allow to Stay</option>
                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>✗ Reject</option>
                                <option value="waitlisted" {{ $application->status === 'waitlisted' ? 'selected' : '' }}>⏸ Waitlist</option>
                            </select>
                            <small class="text-muted">Select "Accept - Allow to Stay" to choose this seeker for your dorm</small>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Your Private Notes</label>
                            <textarea name="owner_notes" class="form-control @error('owner_notes') is-invalid @enderror" rows="4" 
                                      placeholder="Add private notes about this seeker (e.g., 'Good fit for room 101', 'Follow up on references')...">{{ old('owner_notes', $application->owner_notes) }}</textarea>
                            @error('owner_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        @if($application->status !== 'accepted')
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="reject_others" class="form-check-input" id="rejectOthers" checked>
                                <label class="form-check-label" for="rejectOthers">
                                    <strong>Automatically reject other applications</strong> for this vacancy when accepting this seeker
                                </label>
                                <small class="text-muted d-block">This ensures only one seeker is selected per vacancy</small>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            <strong>Save Decision</strong>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($application->status !== 'accepted')
                            <form method="POST" action="{{ route('owner.applications.quickAction', $application) }}">
                                @csrf
                                <input type="hidden" name="reject_others" value="1">
                                <button type="submit" name="action" value="accept" class="btn btn-success w-100 btn-lg"
                                        onclick="return confirm('Accept this seeker to stay in your dorm? Other applications for this vacancy will be automatically rejected.')">
                                    ✓ Accept to Stay in Dorm
                                </button>
                            </form>
                        @else
                            <div class="alert alert-success mb-0">
                                <strong>✓ Selected to Stay</strong><br>
                                <small>This seeker has been accepted to stay in your dorm.</small>
                            </div>
                        @endif

                        @if($application->status !== 'rejected')
                            <form method="POST" action="{{ route('owner.applications.quickAction', $application) }}">
                                @csrf
                                <button type="submit" name="action" value="reject" class="btn btn-outline-danger w-100"
                                        onclick="return confirm('Reject this application?')">
                                    ✗ Reject Application
                                </button>
                            </form>
                        @endif

                        @if($application->status !== 'waitlisted')
                            <form method="POST" action="{{ route('owner.applications.quickAction', $application) }}">
                                @csrf
                                <button type="submit" name="action" value="waitlist" class="btn btn-outline-warning w-100">
                                    ⏸ Add to Waitlist
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('owner.applications.index') }}" class="btn btn-outline-secondary w-100">
                            ← Back to All Applications
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

