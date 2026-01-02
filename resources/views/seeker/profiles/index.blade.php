@extends('seeker.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');
    
    :root {
        --primary: #0ea5e9;
        --primary-dark: #0284c7;
        --primary-light: #38bdf8;
        --secondary: #06b6d4;
        --accent: #3b82f6;
        --gold: #fbbf24;
        --success: #10b981;
        --bg-main: #f0f9ff;
        --bg-secondary: #e0f2fe;
        --card-bg: #ffffff;
        --text-primary: #0c4a6e;
        --text-secondary: #075985;
        --border-color: #bae6fd;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background: radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                    linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        color: var(--text-primary);
        min-height: 100vh;
    }
    
    .hero-section {
        padding: 40px 0 60px;
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
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 20px;
        line-height: 1.2;
    }
    
    .hero-title span {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
        color: var(--text-secondary);
        max-width: 700px;
        margin: 0 auto 40px;
    }
    
    .search-container {
        background: white;
        border-radius: 24px;
        padding: 50px;
        max-width: 900px;
        margin: 0 auto 40px;
        box-shadow: 0 20px 60px rgba(14, 165, 233, 0.12);
        border: 2px solid rgba(14, 165, 233, 0.1);
    }
    
    .search-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .search-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 10px;
    }
    
    .search-header p {
        color: var(--text-secondary);
    }
    
    .search-box {
        position: relative;
        margin-bottom: 30px;
    }
    
    .search-input {
        width: 100%;
        padding: 18px 60px 18px 24px;
        border: 2px solid rgba(14, 165, 233, 0.2);
        border-radius: 16px;
        font-size: 1.05rem;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
    }
    
    .search-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .search-btn:hover {
        transform: translateY(-50%) scale(1.05);
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
    }
    
    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 40px 0;
    }
    
    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 2px solid rgba(14, 165, 233, 0.1);
    }
    
    .divider span {
        padding: 0 20px;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }
    
    .ai-mode-section {
        text-align: center;
        padding: 40px;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.03), rgba(59, 130, 246, 0.03));
        border-radius: 20px;
        border: 2px dashed rgba(14, 165, 233, 0.3);
    }
    
    .ai-icon {
        font-size: 4rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 20px;
    }
    
    .ai-mode-section h4 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        color: var(--text-primary);
        margin-bottom: 15px;
    }
    
    .ai-mode-section p {
        color: var(--text-secondary);
        margin-bottom: 30px;
        font-size: 1.05rem;
    }
    
    .btn-ai-mode {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 16px 48px;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn-ai-mode:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 36px rgba(14, 165, 233, 0.4);
    }
    
    .usage-info {
        background: rgba(251, 191, 36, 0.1);
        border: 1px solid rgba(251, 191, 36, 0.3);
        border-radius: 12px;
        padding: 15px 20px;
        margin-top: 25px;
        display: inline-block;
    }
    
    .usage-info i {
        color: var(--gold);
        margin-right: 8px;
    }
    
    .usage-info span {
        color: var(--text-primary);
        font-weight: 600;
    }
    
    .results-container {
        max-width: 1200px;
        margin: 60px auto;
        @if($seekers->count() > 0) display: block; @else display: none; @endif
    }
    
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .results-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--text-primary);
    }
    
    .filter-btn {
        background: white;
        border: 2px solid rgba(14, 165, 233, 0.2);
        padding: 10px 20px;
        border-radius: 10px;
        color: var(--text-primary);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .filter-btn:hover {
        border-color: var(--primary);
        background: rgba(14, 165, 233, 0.05);
    }
    
    .roommate-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }
    
    .roommate-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 2px solid rgba(14, 165, 233, 0.1);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .roommate-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--primary), var(--secondary));
    }
    
    .roommate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 36px rgba(14, 165, 233, 0.15);
        border-color: var(--primary);
    }
    
    .ai-match-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, var(--gold), #f59e0b);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .profile-header {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-light), var(--accent));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .profile-info h4 {
        font-size: 1.4rem;
        color: var(--text-primary);
        margin-bottom: 5px;
        font-weight: 700;
    }
    
    .profile-meta {
        display: flex;
        gap: 15px;
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    
    .profile-meta i {
        color: var(--primary);
    }
    
    .match-score {
        display: inline-block;
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
    }
    
    .interests {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }
    
    .interest-tag {
        background: rgba(14, 165, 233, 0.1);
        color: var(--primary);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .profile-bio {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    
    .card-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-request {
        flex: 1;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-request:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
    }
    
    .btn-message {
        flex: 1;
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        padding: 12px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        text-align: center;
    }
    
    .btn-message:hover {
        background: rgba(14, 165, 233, 0.05);
    }
    
    .selected-badge {
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 10px;
    }
    
    .loading {
        text-align: center;
        padding: 60px;
    }
    
    .spinner {
        border: 4px solid rgba(14, 165, 233, 0.1);
        border-top: 4px solid var(--primary);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .filters-panel {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        display: none;
    }
    
    .filters-panel.active {
        display: block;
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .search-container {
            padding: 30px 20px;
        }
        
        .roommate-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="hero-section">
    <div class="container">
        <span class="hero-badge"><i class="fas fa-sparkles me-2"></i>AI Powered Matching</span>
        <h1 class="hero-title">Find Your <span>Perfect Roommate</span></h1>
        <p class="hero-subtitle">Connect with compatible roommates through our advanced AI matching system or search manually based on your preferences</p>
    </div>
</div>

<div class="container">
    <div class="search-container">
        <div class="search-header">
            <h3>Manual Search</h3>
            <p>Search for potential roommates by name or interests</p>
        </div>
        
        <form method="GET" action="{{ route('seeker.profiles.index') }}" id="searchForm">
            <div class="search-box">
                <input 
                    type="text" 
                    class="search-input" 
                    name="search"
                    id="manualSearch"
                    placeholder="Search by name or interests (e.g., 'gaming', 'music', 'sports')..."
                    value="{{ request('search') }}"
                >
                <button type="submit" class="search-btn">
                    <i class="fas fa-search me-2"></i>Search
                </button>
            </div>
        </form>
        
        <div class="divider">
            <span>Or try something smarter</span>
        </div>
        
        <div class="ai-mode-section">
            <i class="fas fa-brain ai-icon"></i>
            <h4>Switch to AI Mode</h4>
            <p>Let our AI analyze your profile and preferences to find the most compatible roommates for you</p>
            <button class="btn-ai-mode" onclick="activateAIMode()">
                <i class="fas fa-magic me-2"></i>Activate AI Match
            </button>
            <div class="usage-info">
                <i class="fas fa-bolt"></i>
                <span>3 AI searches remaining today</span>
                <a href="#" style="color: var(--gold); margin-left: 10px; font-weight: 600;">Upgrade for unlimited</a>
            </div>
        </div>
    </div>
    
    <div class="filters-panel" id="filtersPanel">
        <form method="GET" action="{{ route('seeker.profiles.index') }}" class="row g-3">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <div class="col-md-3">
                <label class="form-label fw-bold">Gender Preference</label>
                <select name="gender_pref" class="form-select">
                    <option value="">All</option>
                    <option value="Male" {{ request('gender_pref') === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender_pref') === 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Mixed" {{ request('gender_pref') === 'Mixed' ? 'selected' : '' }}>Mixed</option>
                    <option value="Any" {{ request('gender_pref') === 'Any' ? 'selected' : '' }}>Any</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Smoking</label>
                <select name="smoking" class="form-select">
                    <option value="">Any</option>
                    <option value="0" {{ request('smoking') === '0' ? 'selected' : '' }}>Non-smoker</option>
                    <option value="1" {{ request('smoking') === '1' ? 'selected' : '' }}>Smoker</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Pet Friendly</label>
                <select name="pet_friendly" class="form-select">
                    <option value="">Any</option>
                    <option value="1" {{ request('pet_friendly') === '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ request('pet_friendly') === '0' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 me-2">Apply Filters</button>
                <a href="{{ route('seeker.profiles.index') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
        </form>
    </div>
    
    @if($seekers->isEmpty())
        <div class="results-container" style="display: block;">
            <div class="alert alert-info text-center" style="background: white; border-radius: 20px; padding: 40px;">
                <h5>No seekers found</h5>
                <p class="mb-0">No seekers match your search criteria. Try adjusting your filters or check back later.</p>
            </div>
        </div>
    @else
        <div class="results-container" id="resultsContainer">
            <div class="results-header">
                <h3 id="resultsTitle">Search Results ({{ $seekers->total() }})</h3>
                <button class="filter-btn" onclick="toggleFilters()">
                    <i class="fas fa-filter me-2"></i>Filters
                </button>
            </div>
            
            <div class="roommate-grid" id="roommateGrid">
                @foreach($seekers as $seeker)
                    @php
                        $hasSelected = in_array($seeker->id, $myConnections);
                        $interests = $seeker->detail->interests ?? [];
                        $preferredUnis = $seeker->detail->preferred_universities ?? [];
                    @endphp
                    <div class="roommate-card">
                        <div class="profile-header">
                            <div class="profile-avatar">{{ strtoupper(substr($seeker->name, 0, 1)) }}</div>
                            <div class="profile-info">
                                <h4>{{ $seeker->name }}</h4>
                                <div class="profile-meta">
                                    @if($seeker->detail->room_type_pref)
                                        <span><i class="fas fa-home me-1"></i>{{ $seeker->detail->room_type_pref }}</span>
                                    @endif
                                    @if($seeker->detail->gender_pref)
                                        <span><i class="fas fa-venus-mars me-1"></i>{{ $seeker->detail->gender_pref }}</span>
                                    @endif
                                </div>
                                @if($seeker->detail->budget_min && $seeker->detail->budget_max)
                                    <div class="profile-meta">
                                        <span><i class="fas fa-money-bill-wave me-1"></i>TK {{ number_format($seeker->detail->budget_min) }} - {{ number_format($seeker->detail->budget_max) }}/month</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        @if(count($interests) > 0)
                            <div class="interests">
                                @foreach(array_slice($interests, 0, 5) as $interest)
                                    <span class="interest-tag"><i class="fas fa-tag me-1"></i>{{ $interest }}</span>
                                @endforeach
                                @if(count($interests) > 5)
                                    <span class="interest-tag">+{{ count($interests) - 5 }} more</span>
                                @endif
                            </div>
                        @endif
                        
                        @if($seeker->detail->bio)
                            <p class="profile-bio">{{ \Illuminate\Support\Str::limit($seeker->detail->bio, 150) }}</p>
                        @endif
                        
                        <div class="card-actions">
                            @if($hasSelected)
                                <div class="selected-badge w-100">
                                    <i class="fas fa-check-circle me-2"></i>Selected as Roommate
                                </div>
                                <a href="{{ route('seeker.profiles.show', $seeker) }}" class="btn-message w-100">
                                    <i class="fas fa-eye me-2"></i>View Profile
                                </a>
                            @else
                                <button type="button" class="btn-request" data-bs-toggle="modal" data-bs-target="#selectRoommateModal{{ $seeker->id }}">
                                    <i class="fas fa-user-plus me-2"></i>Send Request
                                </button>
                                <a href="{{ route('seeker.profiles.show', $seeker) }}" class="btn-message">
                                    <i class="fas fa-comment me-2"></i>View Profile
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Select Roommate Modal -->
                    <div class="modal fade" id="selectRoommateModal{{ $seeker->id }}" tabindex="-1" aria-labelledby="selectRoommateModalLabel{{ $seeker->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="selectRoommateModalLabel{{ $seeker->id }}">Select {{ $seeker->name }} as Roommate</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('seeker.profiles.select-roommate', $seeker) }}">
                                    @csrf
                                    <div class="modal-body">
                                        <p>Are you sure you want to select <strong>{{ $seeker->name }}</strong> as a potential roommate?</p>
                                        <div class="mb-3">
                                            <label for="message{{ $seeker->id }}" class="form-label">Optional Message</label>
                                            <textarea class="form-control" id="message{{ $seeker->id }}" name="message" rows="3" placeholder="Send a message to {{ $seeker->name }} (e.g., 'Hi, I'm interested in being your roommate!')"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Select as Roommate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                {{ $seekers->links() }}
            </div>
        </div>
    @endif
</div>

<script>
    function toggleFilters() {
        const panel = document.getElementById('filtersPanel');
        panel.classList.toggle('active');
    }
    
    function activateAIMode() {
        // For now, this will just show all seekers (AI matching can be implemented later)
        // You can add actual AI matching logic here
        alert('AI Mode: This feature will analyze your profile and find the most compatible roommates. Coming soon!');
        
        // For demonstration, we can redirect to show all seekers
        // window.location.href = '{{ route("seeker.profiles.index") }}';
    }
    
    // Allow Enter key to trigger search
    document.getElementById('manualSearch')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('searchForm').submit();
        }
    });
    
    // Show filters panel if there are active filters
    @if(request('gender_pref') || request('smoking') !== null || request('pet_friendly') !== null)
        document.getElementById('filtersPanel').classList.add('active');
    @endif
</script>
@endsection
