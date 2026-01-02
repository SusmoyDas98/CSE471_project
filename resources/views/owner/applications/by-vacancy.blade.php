@extends('owner.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-0">Applications for {{ $vacancy->room->dorm->name }} — {{ $vacancy->room->label }}</h1>
            <p class="text-muted small mb-0">Review and select which seeker can stay in this room</p>
        </div>
        <a href="{{ route('owner.applications.index') }}" class="btn btn-outline-secondary btn-sm">← All Applications</a>
    </div>

    @if($applications->isEmpty())
        <div class="alert alert-info">
            <h5>No applications yet</h5>
            <p class="mb-0">No dorm seekers have applied for this vacancy yet. Check back later.</p>
        </div>
    @else
        <div class="alert alert-primary">
            <strong>Review all applications below and select which seeker can stay in this room.</strong>
            You can accept one seeker per vacancy.
        </div>

        <div class="row">
            @foreach($applications as $application)
                <div class="col-md-6 mb-3">
                    <div class="card h-100 {{ $application->status === 'accepted' ? 'border-success' : '' }}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $application->seeker->name ?? 'User #' . $application->user_id }}</h6>
                                <small class="text-muted">{{ $application->seeker->email ?? 'N/A' }}</small>
                            </div>
                            <span class="badge 
                                @if($application->status === 'accepted') text-bg-success
                                @elseif($application->status === 'rejected') text-bg-danger
                                @elseif($application->status === 'waitlisted') text-bg-warning
                                @elseif($application->status === 'reviewing') text-bg-info
                                @else text-bg-secondary
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <strong>Move-in Date:</strong> {{ optional($application->move_in_date)->format('M d, Y') ?? 'Not specified' }}<br>
                                <strong>Budget:</strong> {{ $application->budget ? 'TK ' . number_format($application->budget) : 'Not specified' }}<br>
                                <strong>Applied:</strong> {{ $application->created_at->format('M d, Y') }}
                            </div>

                            @if($application->message)
                                <div class="mb-2">
                                    <strong>Message:</strong>
                                    <p class="small mb-0">{{ \Illuminate\Support\Str::limit($application->message, 150) }}</p>
                                </div>
                            @endif

                            @if($application->seeker->detail)
                                <div class="mb-2 border-top pt-2">
                                    <strong>Profile:</strong>
                                    <div class="small">
                                        @if($application->seeker->detail->phone)
                                            <div><strong>Phone:</strong> {{ $application->seeker->detail->phone }}</div>
                                        @endif
                                        @if($application->seeker->detail->bio)
                                            <div><strong>Bio:</strong> {{ \Illuminate\Support\Str::limit($application->seeker->detail->bio, 80) }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('owner.applications.show', $application) }}" class="btn btn-sm btn-outline-primary">
                                    View Full Details
                                </a>
                                @if($application->status !== 'accepted')
                                    <form method="POST" action="{{ route('owner.applications.quickAction', $application) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="reject_others" value="1">
                                        <button type="submit" name="action" value="accept" class="btn btn-sm btn-success"
                                                onclick="return confirm('Accept this seeker to stay? Other applications will be rejected.')">
                                            ✓ Accept to Stay
                                        </button>
                                    </form>
                                @else
                                    <span class="badge text-bg-success">Selected to Stay</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

