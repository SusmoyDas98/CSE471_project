@extends('seeker.layout')

@section('content')
    <div class="mb-4">
        <a href="{{ route('seeker.profiles.index') }}" class="btn btn-outline-secondary mb-3">← Back to Browse Seekers</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Seeker Profile -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $user->name }}</h4>
                    <small class="text-white-50">{{ $user->email }}</small>
                </div>
                <div class="card-body">
                    @if($user->detail->bio)
                        <div class="mb-4">
                            <h5>About</h5>
                            <p class="mb-0">{{ $user->detail->bio }}</p>
                        </div>
                        <hr>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Contact & Basic Info</h5>
                            @if($user->detail->phone)
                                <p class="mb-2"><strong>Phone:</strong> {{ $user->detail->phone }}</p>
                            @endif
                            <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                            @if($user->detail->move_in_date)
                                <p class="mb-2"><strong>Preferred Move-in:</strong> {{ $user->detail->move_in_date->format('F d, Y') }}</p>
                            @endif
                            @if($user->detail->stay_length_months)
                                <p class="mb-0"><strong>Stay Duration:</strong> {{ $user->detail->stay_length_months }} months</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Budget & Preferences</h5>
                            @if($user->detail->budget_min && $user->detail->budget_max)
                                <p class="mb-2"><strong>Budget Range:</strong> TK {{ number_format($user->detail->budget_min) }} - TK {{ number_format($user->detail->budget_max) }}/month</p>
                            @endif
                            @if($user->detail->room_type_pref)
                                <p class="mb-2"><strong>Room Type:</strong> {{ $user->detail->room_type_pref }}</p>
                            @endif
                            @if($user->detail->gender_pref)
                                <p class="mb-2"><strong>Gender Preference:</strong> {{ $user->detail->gender_pref }}</p>
                            @endif
                            @if($user->detail->has_roommate)
                                <p class="mb-0"><strong>Has Roommate:</strong> Yes
                                    @if($user->detail->roommate_count)
                                        ({{ $user->detail->roommate_count }} roommate(s))
                                    @endif
                                </p>
                            @else
                                <p class="mb-0"><strong>Has Roommate:</strong> No</p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Lifestyle Preferences</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>Smoking:</strong> 
                                    <span class="badge {{ $user->detail->smoking ? 'bg-warning' : 'bg-success' }}">
                                        {{ $user->detail->smoking ? 'Yes' : 'No' }}
                                    </span>
                                </li>
                                <li class="mb-2">
                                    <strong>Pet Friendly:</strong> 
                                    <span class="badge {{ $user->detail->pet_friendly ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $user->detail->pet_friendly ? 'Yes' : 'No' }}
                                    </span>
                                </li>
                                @if($user->detail->cleanliness_level)
                                    <li class="mb-2">
                                        <strong>Cleanliness Level:</strong> 
                                        <div class="d-inline-flex align-items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="badge {{ $i <= $user->detail->cleanliness_level ? 'bg-success' : 'bg-light text-dark' }} me-1">
                                                    {{ $i }}
                                                </span>
                                            @endfor
                                        </div>
                                    </li>
                                @endif
                                @if($user->detail->noise_tolerance)
                                    <li class="mb-2">
                                        <strong>Noise Tolerance:</strong> 
                                        <div class="d-inline-flex align-items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="badge {{ $i <= $user->detail->noise_tolerance ? 'bg-info' : 'bg-light text-dark' }} me-1">
                                                    {{ $i }}
                                                </span>
                                            @endfor
                                        </div>
                                    </li>
                                @endif
                                @if($user->detail->wake_time)
                                    <li class="mb-2"><strong>Wake Time:</strong> {{ \Carbon\Carbon::parse($user->detail->wake_time)->format('g:i A') }}</li>
                                @endif
                                @if($user->detail->sleep_time)
                                    <li class="mb-0"><strong>Sleep Time:</strong> {{ \Carbon\Carbon::parse($user->detail->sleep_time)->format('g:i A') }}</li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Study or Work & Habits</h5>
                            @if($user->detail->study_habits)
                                <p class="mb-2"><strong>Study or Work Habit:</strong> {{ $user->detail->study_habits }}</p>
                            @endif
                            @if($user->detail->location_priority)
                                <p class="mb-2"><strong>Location Priority:</strong> {{ $user->detail->location_priority }}</p>
                            @endif
                        </div>
                    </div>

                    @if($user->detail->languages && count($user->detail->languages) > 0)
                        <div class="mb-4">
                            <h5>Languages</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($user->detail->languages as $language)
                                    <span class="badge bg-primary">{{ $language }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($user->detail->interests && count($user->detail->interests) > 0)
                        <div class="mb-4">
                            <h5>Interests</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($user->detail->interests as $interest)
                                    <span class="badge bg-secondary">{{ $interest }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($user->detail->amenities_priority && count($user->detail->amenities_priority) > 0)
                        <div class="mb-4">
                            <h5>Priority Amenities</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($user->detail->amenities_priority as $amenity)
                                    <span class="badge bg-info">{{ $amenity }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($user->detail->preferred_universities && count($user->detail->preferred_universities) > 0)
                        <div class="mb-4">
                            <h5>Preferred Universities</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($user->detail->preferred_universities as $university)
                                    <span class="badge bg-warning text-dark">{{ $university }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">View this seeker's preferences to decide if they would be a good roommate match for you.</p>
                    
                    @if($roommateConnection)
                        <div class="alert alert-info mb-3">
                            <strong>✓ You've selected this seeker as a potential roommate!</strong>
                            @if($roommateConnection->message)
                                <p class="small mb-0 mt-1">Your message: "{{ $roommateConnection->message }}"</p>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('seeker.profiles.remove-roommate', $user) }}" class="mb-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Remove this roommate selection?')">
                                Remove Selection
                            </button>
                        </form>
                    @else
                        <button type="button" class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#selectRoommateModal">
                            <strong>🤝 Select as Roommate</strong>
                        </button>
                    @endif
                    
                    <a href="{{ route('seeker.profiles.index') }}" class="btn btn-outline-secondary w-100 mb-2">
                        Browse More Seekers
                    </a>
                    <a href="{{ route('seeker.vacancies.index') }}" class="btn btn-outline-primary w-100">
                        Browse Available Dorms
                    </a>
                </div>
            </div>

            <!-- Compatibility Notes -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">💡 Tips</h5>
                </div>
                <div class="card-body">
                    <p class="small mb-0">
                        <strong>Looking for a roommate?</strong> Review this seeker's preferences and lifestyle habits to see if you're compatible. 
                        Consider factors like smoking, pet preferences, cleanliness, and study or work habits when making your decision.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Select Roommate Modal -->
    <div class="modal fade" id="selectRoommateModal" tabindex="-1" aria-labelledby="selectRoommateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectRoommateModalLabel">Select {{ $user->name }} as Roommate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('seeker.profiles.select-roommate', $user) }}">
                    @csrf
                    <div class="modal-body">
                        <p>You're about to select <strong>{{ $user->name }}</strong> as a potential roommate. This will let them know you're interested in being roommates.</p>
                        <div class="mb-3">
                            <label class="form-label">Optional Message</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Add a personal message (optional)..." maxlength="500">{{ old('message') }}</textarea>
                            <small class="text-muted">Let them know why you think you'd be good roommates!</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <strong>Select as Roommate</strong>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

