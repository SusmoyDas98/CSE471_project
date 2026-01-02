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
    
    .dorm-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 2px solid rgba(14, 165, 233, 0.1);
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        transition: all 0.3s;
    }
    
    .dorm-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.15);
    }
    
    .workflow-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 2px solid rgba(14, 165, 233, 0.1);
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
    }
    
    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s;
    }
    
    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
    }
    
    .btn-warning-modern {
        background: linear-gradient(135deg, var(--gold), #f59e0b);
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s;
    }
    
    .room-item, .vacancy-item {
        background: rgba(14, 165, 233, 0.05);
        border-radius: 12px;
        padding: 20px;
        margin-top: 15px;
        border: 2px solid rgba(14, 165, 233, 0.1);
    }
    
    .btn-add-room {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
    }
    
    .btn-add-room:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
        color: white;
    }
    
    .btn-room-edit {
        background: white;
        color: var(--text-primary);
        border: 2px solid rgba(14, 165, 233, 0.3);
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-room-edit:hover {
        background: rgba(14, 165, 233, 0.1);
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-2px);
    }
    
    .btn-room-delete {
        background: white;
        color: #dc3545;
        border: 2px solid rgba(220, 53, 69, 0.3);
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-room-delete:hover {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
</style>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-building me-2"></i>Manage Your Properties</span>
        <h1 class="hero-title">Your Dorms & Vacancies</h1>
        <p class="text-muted">Manage your dorm properties, rooms, and applications</p>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div></div>
        <div class="d-flex gap-2">
            @php
                $pendingCount = \App\Models\Application::whereHas('vacancy.room.dorm', function($q) {
                    $q->where('user_id', auth()->id());
                })->where('status', 'submitted')->count();
            @endphp
            @if($pendingCount > 0)
                <a class="btn-warning-modern position-relative" href="{{ route('owner.applications.index', ['status' => 'submitted']) }}">
                    Review Applications
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $pendingCount }}
                    </span>
                </a>
            @endif
            <a class="btn-primary-modern" href="{{ route('owner.dorms.create') }}">
                <i class="fas fa-plus me-2"></i>Add New Dorm
            </a>
        </div>
    </div>

    <!-- Workflow Guide -->
    <div class="workflow-card">
        <h4 style="font-family: 'Playfair Display', serif; color: var(--text-primary); margin-bottom: 25px;">
            <i class="fas fa-list-check me-2"></i>How to Announce Vacancies & Get Applications
        </h4>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">1</span>
                    <div>
                        <strong>Add Dorm</strong>
                        <div class="small text-muted">Create your dorm listing</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">2</span>
                    <div>
                        <strong>Add Rooms</strong>
                        <div class="small text-muted">Add rooms to your dorm</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="d-flex align-items-center">
                    <span class="badge bg-success rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">3</span>
                    <div>
                        <strong>Post Vacancy</strong>
                        <div class="small text-muted">Announce available rooms</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="d-flex align-items-center">
                    <span class="badge bg-warning rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">4</span>
                    <div>
                        <strong>Review Applications</strong>
                        <div class="small text-muted">Seekers will apply & you review</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($pendingCount > 0)
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 16px; border: 2px solid var(--gold);">
            <strong><i class="fas fa-bell me-2"></i>You have {{ $pendingCount }} pending application(s) to review!</strong> 
            Review applications from dorm seekers and select which seekers can stay in your dorm.
            <a href="{{ route('owner.applications.index', ['status' => 'submitted']) }}" class="alert-link fw-bold">Review now →</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($dorms as $dorm)
        <div class="dorm-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h4 style="font-family: 'Playfair Display', serif; color: var(--text-primary); margin-bottom: 5px;">
                        {{ $dorm->name }}
                    </h4>
                    <div class="text-muted mb-2">
                        <i class="fas fa-map-marker-alt me-1"></i>{{ $dorm->city }}
                    </div>
                    <p class="mb-2">{{ $dorm->description }}</p>
                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-star me-1"></i>Amenities: {{ $dorm->amenities ? implode(', ', $dorm->amenities) : 'N/A' }}
                        </small>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('owner.dorms.edit', $dorm) }}">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <form class="d-inline" method="POST" action="{{ route('owner.dorms.destroy', $dorm) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete dorm?')">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <h5 style="font-family: 'Playfair Display', serif; color: var(--text-primary); margin: 0;">
                    <i class="fas fa-door-open me-2"></i>Rooms
                </h5>
                <a class="btn btn-add-room" href="{{ route('owner.rooms.create', $dorm) }}">
                    <i class="fas fa-plus me-1"></i>Add Room
                </a>
            </div>
            
            @forelse($dorm->rooms as $room)
                <div class="room-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <strong>{{ $room->label }}</strong> — Capacity {{ $room->capacity }}, Price {{ $room->price ? 'TK ' . number_format($room->price) : 'n/a' }}
                            <div class="text-muted small mt-1">
                                <i class="fas fa-info-circle me-1"></i>Type: {{ $room->room_type ?? 'n/a' }} | Gender: {{ $room->gender_policy ?? 'n/a' }}
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a class="btn btn-room-edit" href="{{ route('owner.rooms.edit', [$dorm, $room]) }}" title="Edit Room">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <form class="d-inline" method="POST" action="{{ route('owner.rooms.destroy', [$dorm, $room]) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-room-delete" onclick="return confirm('Are you sure you want to delete this room? This will also delete all associated vacancies.')" title="Delete Room">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <div class="fw-semibold"><i class="fas fa-bullhorn me-2"></i>Vacancies</div>
                        <a class="btn btn-sm btn-success" href="{{ route('owner.vacancies.create', $room) }}">
                            <i class="fas fa-plus me-1"></i>Announce Vacancy
                        </a>
                    </div>
                    @forelse($room->vacancies as $vacancy)
                        <div class="vacancy-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge text-bg-info">{{ $vacancy->status }}</span>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>From {{ optional($vacancy->available_from)->format('Y-m-d') ?? 'n/a' }}
                                        </small>
                                        @php
                                            $appCount = $vacancy->applications()->count();
                                            $pendingCount = $vacancy->applications()->where('status', 'submitted')->count();
                                        @endphp
                                        @if($appCount > 0)
                                            <a href="{{ route('owner.applications.byVacancy', $vacancy) }}" class="badge text-bg-warning text-decoration-none">
                                                {{ $appCount }} Application{{ $appCount > 1 ? 's' : '' }}
                                                @if($pendingCount > 0)
                                                    ({{ $pendingCount }} pending)
                                                @endif
                                            </a>
                                        @endif
                                    </div>
                                    <div class="small">{{ $vacancy->notes }}</div>
                                </div>
                                <div class="d-flex gap-1">
                                    @if($appCount > 0)
                                        <a class="btn btn-sm btn-primary" href="{{ route('owner.applications.byVacancy', $vacancy) }}" title="Review Applications">
                                            <i class="fas fa-eye me-1"></i>Review
                                        </a>
                                    @endif
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('owner.vacancies.edit', $vacancy) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted small mt-3 text-center py-3" style="background: rgba(14, 165, 233, 0.03); border-radius: 8px;">
                            <i class="fas fa-info-circle me-1"></i>
                            <em>No vacancies announced yet.</em> 
                            <a href="{{ route('owner.vacancies.create', $room) }}" class="text-decoration-none fw-bold">Click here to announce a vacancy</a> so seekers can apply!
                        </div>
                    @endforelse
                </div>
            @empty
                <div class="text-muted small mt-3 text-center py-4" style="background: rgba(14, 165, 233, 0.03); border-radius: 12px;">
                    <i class="fas fa-door-open fa-2x mb-2 d-block text-muted"></i>
                    <em>No rooms added yet.</em> 
                    <a href="{{ route('owner.rooms.create', $dorm) }}" class="text-decoration-none fw-bold">Add a room</a> first, then you can announce vacancies!
                </div>
            @endforelse
        </div>
    @empty
        <div class="alert alert-info text-center" style="background: white; border-radius: 20px; padding: 50px; border: 2px solid rgba(14, 165, 233, 0.2);">
            <i class="fas fa-rocket fa-3x mb-3 text-primary"></i>
            <h4 style="font-family: 'Playfair Display', serif; color: var(--text-primary);">Get Started!</h4>
            <p class="mb-3">You haven't created any dorms yet. Follow these steps to start receiving applications:</p>
            <ol class="text-start mb-4" style="max-width: 600px; margin: 0 auto;">
                <li class="mb-2"><strong>Add a Dorm</strong> - Click the "Add New Dorm" button above to create your first dorm listing</li>
                <li class="mb-2"><strong>Add Rooms</strong> - Add rooms to your dorm with details like capacity, price, and type</li>
                <li class="mb-2"><strong>Announce Vacancy</strong> - Post vacancies for available rooms so seekers can find them</li>
                <li><strong>Review Applications</strong> - When seekers apply, review and accept the best candidates</li>
            </ol>
            <a href="{{ route('owner.dorms.create') }}" class="btn-primary-modern">
                <i class="fas fa-plus me-2"></i>Create Your First Dorm
            </a>
        </div>
    @endforelse
</div>
@endsection
