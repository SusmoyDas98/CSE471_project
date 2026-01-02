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
        padding: 30px;
        border: 2px solid rgba(14, 165, 233, 0.1);
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
    }
    
    .vacancy-card {
        background: white;
        border-radius: 20px;
        padding: 0;
        border: 2px solid rgba(14, 165, 233, 0.1);
        margin-bottom: 25px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        transition: all 0.3s;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .vacancy-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 36px rgba(14, 165, 233, 0.15);
        border-color: var(--primary);
    }
    
    .vacancy-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--success), #059669);
    }
    
    .vacancy-card-body {
        padding: 25px;
        flex-grow: 1;
    }
    
    .vacancy-card-footer {
        padding: 20px 25px;
        background: rgba(14, 165, 233, 0.03);
        border-top: 1px solid rgba(14, 165, 233, 0.1);
    }
    
    .availability-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid rgba(14, 165, 233, 0.2);
        padding: 12px 16px;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
    }
    
    .btn-filter {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
    }
    
    .btn-view {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
    }
    
    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
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
        color: var(--primary);
    }
</style>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-search me-2"></i>Find Your Perfect Dorm</span>
        <h1 class="hero-title">Available Dorm Rooms</h1>
        <p class="text-muted">Browse and apply for available dorm rooms</p>
    </div>
</div>

<div class="container mb-5">
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('seeker.dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
    <!-- Filters -->
    <div class="filter-card">
        <form method="GET" action="{{ route('seeker.vacancies.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Filter by City</label>
                <select name="city" class="form-select">
                    <option value="">All Cities</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Max Price (per month)</label>
                <input type="number" name="max_price" class="form-control" 
                       placeholder="e.g., 10000" value="{{ request('max_price') }}">
                <small class="text-muted">Enter maximum price in TK</small>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn-filter me-2">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <a href="{{ route('seeker.vacancies.index') }}" class="btn btn-outline-secondary" style="border-radius: 12px;">Clear</a>
            </div>
        </form>
    </div>

    @if($vacancies->isEmpty())
        <div class="alert alert-info text-center" style="background: white; border-radius: 20px; padding: 50px; border: 2px solid rgba(14, 165, 233, 0.2);">
            <i class="fas fa-inbox fa-3x mb-3 text-primary"></i>
            <h5>No vacancies found</h5>
            <p class="mb-3">There are no available dorm rooms matching your criteria.</p>
            <p class="mb-0 small text-muted">Try adjusting your filters or check back later.</p>
        </div>
    @else
        <div class="row">
            @foreach($vacancies as $vacancy)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="vacancy-card" style="position: relative;">
                        <span class="availability-badge">
                            <i class="fas fa-check-circle me-1"></i>Available
                        </span>
                        <div class="vacancy-card-body">
                            <h5 style="font-family: 'Playfair Display', serif; color: var(--text-primary); margin-bottom: 8px;">
                                {{ $vacancy->room->dorm->name }}
                            </h5>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $vacancy->room->dorm->city }}
                            </p>

                            <div class="mb-3">
                                <div class="small mb-2">
                                    <i class="fas fa-door-open me-2 text-muted"></i><strong>Room:</strong> {{ $vacancy->room->label }}
                                </div>
                                <div class="small mb-2">
                                    <i class="fas fa-home me-2 text-muted"></i><strong>Type:</strong> {{ $vacancy->room->room_type ?? 'N/A' }}
                                    @if($vacancy->room->is_shared)
                                        <span class="badge bg-info ms-1">Shared</span>
                                    @endif
                                </div>
                                <div class="small mb-2">
                                    <i class="fas fa-users me-2 text-muted"></i><strong>Capacity:</strong> {{ $vacancy->room->capacity }} person(s)
                                </div>
                                @if($vacancy->room->price)
                                    <div class="small mb-2">
                                        <i class="fas fa-money-bill-wave me-2 text-muted"></i><strong>Price:</strong> 
                                        <span style="color: var(--primary); font-weight: 700;">TK {{ number_format($vacancy->room->price) }}/month</span>
                                    </div>
                                @endif
                            </div>

                            @if($vacancy->room->dorm->amenities)
                                <div class="mb-3">
                                    <strong class="small">Amenities:</strong>
                                    <div class="small text-muted mt-1">
                                        {{ implode(', ', array_slice($vacancy->room->dorm->amenities, 0, 3)) }}
                                        @if(count($vacancy->room->dorm->amenities) > 3)
                                            <span class="text-muted">+{{ count($vacancy->room->dorm->amenities) - 3 }} more</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($vacancy->available_from)
                                <div class="mb-3">
                                    <div class="small">
                                        <i class="fas fa-calendar-alt me-2 text-muted"></i><strong>Available from:</strong> {{ $vacancy->available_from->format('M d, Y') }}
                                    </div>
                                </div>
                            @endif

                            @if($vacancy->notes)
                                <p class="small text-muted mb-0">{{ \Illuminate\Support\Str::limit($vacancy->notes, 100) }}</p>
                            @endif
                        </div>
                        <div class="vacancy-card-footer">
                            <a href="{{ route('seeker.vacancies.show', $vacancy) }}" class="btn-view">
                                <i class="fas fa-eye me-2"></i>View Details & Apply
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $vacancies->links() }}
        </div>
    @endif
</div>
@endsection
