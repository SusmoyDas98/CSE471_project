<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Dorms - DormMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #0ea5e9;
            --secondary: #3b82f6;
            --text-secondary: #6b7280;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }
        
        .search-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .search-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .search-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }
        
        .search-header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }
        
        .ai-mode-card {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.05), rgba(59, 130, 246, 0.05));
            border: 2px dashed rgba(14, 165, 233, 0.3);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .ai-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2.5rem;
        }
        
        .ai-mode-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .ai-mode-card p {
            color: var(--text-secondary);
            font-size: 1.05rem;
            margin-bottom: 25px;
        }
        
        .btn-ai-activate {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-ai-activate:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(14, 165, 233, 0.4);
        }
        
        .search-limit-notice {
            background: linear-gradient(135deg, #fff7ed, #ffedd5);
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .search-limit-notice i {
            color: #f59e0b;
        }
        
        .filters-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.1);
            margin-bottom: 30px;
        }
        
        .filters-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
        }
        
        .form-control, .form-select {
            border: 2px solid rgba(14, 165, 233, 0.15);
            border-radius: 12px;
            padding: 12px 18px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        /* Dropdown checkbox styles */
        .dropdown-checkbox {
            position: relative;
        }

        .dropdown-toggle {
            border: 2px solid rgba(14, 165, 233, 0.15);
            border-radius: 12px;
            padding: 12px 18px;
            background: white;
            text-align: left;
            transition: all 0.3s ease;
        }

        .dropdown-toggle:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .dropdown-menu-checkbox {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 2px solid rgba(14, 165, 233, 0.15);
            max-height: 300px;
            overflow-y: auto;
        }

        .dropdown-menu-checkbox label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-weight: 500;
            cursor: pointer;
        }

        .dropdown-menu-checkbox input {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(14, 165, 233, 0.3);
            border-radius: 6px;
            cursor: pointer;
        }
        
        .btn-search {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 50px;
            font-size: 1.05rem;
            font-weight: 600;
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.25);
            transition: all 0.3s ease;
        }
        
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(14, 165, 233, 0.35);
        }
        
        .results-container {
            margin-top: 40px;
        }
        
        .dorm-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .dorm-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(14, 165, 233, 0.15);
        }

        /* Layout: show dorm cards side-by-side in a responsive grid */
        #dormsList {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 20px;
            align-items: stretch;
        }

        /* wide screens: exactly 3 columns */
        @media (min-width: 1200px) {
            #dormsList {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* medium screens: 2 columns */
        @media (min-width: 768px) and (max-width: 1199px) {
            #dormsList {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .dorm-card {
            width: 100%;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Inline match badge (shown beside the name) */
        .match-badge {
            display: inline-block;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.18);
            margin-left: 10px;
            vertical-align: middle;
        }
        
        .dorm-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .dorm-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin: 20px 0;
            flex: 1 1 auto;
        }
        
        .dorm-info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #475569;
        }
        
        .dorm-info-item i {
            color: var(--primary);
            font-size: 1.2rem;
        }
        
        .dorm-rating {
            color: #fbbf24;
            font-size: 1.2rem;
        }

        .dorm-title {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .dorm-divider {
            display: block;
            width: 100%;
            border: none;
            height: 1px;
            background: #393c41ff; /* dark grey */
            margin: 16px 0 18px; /* move slightly lower */
        }

        .btn-view-dorm {
            margin-top: 12px;
            align-self: flex-start;
        }
        
        .btn-view-dorm {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-view-dorm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
            color: white;
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
        }
        
        .no-results i {
            font-size: 5rem;
            color: #cbd5e1;
            margin-bottom: 20px;
        }
        
        .no-results h3 {
            color: var(--text-secondary);
            margin-bottom: 10px;
        }
        
        .loading {
            text-align: center;
            padding: 40px;
            display: none;
        }
        
        .loading.active {
            display: block;
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
        
        .or-divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }
        
        .or-divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: rgba(14, 165, 233, 0.2);
        }
        
        .or-divider span {
            background: #f0f9ff;
            padding: 0 20px;
            position: relative;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

/* More rounded modal corners */
.modal-content {
    border-radius: 20px;   /* try 16px–24px */
}

/* Optional: softer header/footer rounding */
.modal-header {
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}

.modal-footer {
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
}
.modal-content {
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
}

.modal.fade .modal-dialog {
    transform: scale(0.95);
    transition: transform 0.2s ease-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
}

    </style>
</head>
<body>
    {{-- Page Header + Nav --}}
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>

    <div style="height: 120px;"></div>
   
    <div class="search-container">
        <div class="search-header">
            <h1>Manual Search</h1>
            <p>Search for potential dorms by applying filters</p>
        </div>

        <!-- Manual Search Section -->
        <div class="filters-card">
            <div class="filters-title">
                <i class="fas fa-filter"></i>
                Filters
            </div>

            <form id="searchForm">
                <div class="row">
                    <!-- Dorm Name -->
                    <div class="col-md-6 mb-4">
                        <label for="dorm_name" class="form-label">Dorm Name</label>
                        <input type="text" class="form-control" id="dorm_name" name="dorm_name" placeholder="Search by dorm name...">
                    </div>

                    <!-- Location -->
                    <div class="col-md-6 mb-4">
                        <label for="location" class="form-label">Location</label>
                        <select class="form-select" id="location" name="location">
                            <option value="">All Locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="col-md-6 mb-4">
                        <label for="price_min" class="form-label">Price Range</label>
                        <div class="d-flex gap-2">
                            <input type="number" class="form-control" id="price_min" name="price_min" placeholder="Min" min="0">
                            <input type="number" class="form-control" id="price_max" name="price_max" placeholder="Max" min="0">
                        </div>
                    </div>

                    <!-- Room Types -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Room Types</label>
                        <div class="dropdown dropdown-checkbox">
                            <button class="btn dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                Select Room Types
                            </button>
                            <div class="dropdown-menu dropdown-menu-checkbox">
                                @foreach($roomTypes as $roomType)
                                    <label>
                                        <input type="checkbox" name="room_types[]" value="{{ $roomType }}">
                                        {{ $roomType }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Gender Preference -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Gender Preference</label>
                        <div class="dropdown dropdown-checkbox">
                            <button class="btn dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                Select Gender
                            </button>
                            <div class="dropdown-menu dropdown-menu-checkbox">
                                @foreach($genderPreferences as $gender)
                                    <label>
                                        <input type="checkbox" name="gender_preference[]" value="{{ $gender }}">
                                        {{ $gender }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Facilities -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Facilities</label>
                        <div class="dropdown dropdown-checkbox">
                            <button class="btn dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                Select Facilities
                            </button>
                            <div class="dropdown-menu dropdown-menu-checkbox">
                                @foreach($facilities as $facility)
                                    <label>
                                        <input type="checkbox" name="facilities[]" value="{{ $facility }}">
                                        {{ $facility }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="button" class="btn btn-search" id="manualSearchBtn">
                            <i class="fas fa-search me-2"></i>Search Manually
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="or-divider">
            <span>OR TRY SOMETHING SMARTER</span>
        </div>

        <!-- AI Mode Card -->
        <div class="ai-mode-card">
            <div class="ai-icon">
                <i class="fas fa-brain"></i>
            </div>
            <h3>Switch to AI Mode</h3>
            <p>Let our AI analyze your profile and preferences to find the most compatible dorms for you</p>
            <button type="button" class="btn btn-ai-activate" id="aiSearchBtn">
                <i class="fas fa-magic me-2"></i>ACTIVATE AI MATCH
            </button>
            <div class="search-limit-notice">
                <i class="fas fa-bolt me-2"></i>
                <strong>3 AI searches remaining today</strong>
                <a href="#" class="ms-2" style="color: #f59e0b; text-decoration: underline;">Upgrade for unlimited</a>
            </div>
        </div>

        <!-- Loading -->
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Searching for perfect dorms...</p>
        </div>

        <!-- Results Container -->
        <div class="results-container" id="resultsContainer" style="display: none;">
            <h2 style="font-family: 'Playfair Display', serif; color: var(--primary); margin-bottom: 30px;">
                <i class="fas fa-list-ul me-2"></i>Search Results
            </h2>
            <div id="dormsList"></div>
        </div>
    </div>

<!-- Profile Incomplete Modal -->
<div class="modal fade" id="profileIncompleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Profile Incomplete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>
                    Please complete your profile
                    <strong>(Gender, Marital Status, Profession)</strong>
                    to use AI Search.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Manual Search
        document.getElementById('manualSearchBtn').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('searchForm'));
            
            showLoading();
            
            fetch('{{ route('dorms.search.manual') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    displayResults(data.dorms, data.search_type);
                } else {
                    alert('Search failed: ' + data.message);
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                alert('An error occurred during search');
            });
        });

        // AI Search (send no manual filters so AI ignores manual inputs)
        document.getElementById('aiSearchBtn').addEventListener('click', function() {
            showLoading();

fetch('{{ route('dorms.search.ai') }}', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({})
})
.then(async response => {
    hideLoading();

    // 🚨 Profile incomplete (400)
    if (response.status === 400) {
        const modal = new bootstrap.Modal(
            document.getElementById('profileIncompleteModal')
        );
        modal.show();
        return;
    }

    const data = await response.json();

    if (data.success) {
        displayResults(data.dorms, data.search_type);
    } else {
        console.error(data.message);
    }
})
.catch(error => {
    hideLoading();
    console.error('Error:', error);
});
        });


        function showLoading() {
            document.getElementById('loading').classList.add('active');
            document.getElementById('resultsContainer').style.display = 'none';
        }

        function hideLoading() {
            document.getElementById('loading').classList.remove('active');
        }

        function displayResults(dorms, searchType) {
            const resultsContainer = document.getElementById('resultsContainer');
            const dormsList = document.getElementById('dormsList');
            
            if (dorms.length === 0) {
                dormsList.innerHTML = `
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <h3>No dorms found</h3>
                        <p>Try adjusting your search filters</p>
                    </div>
                `;
            } else {
                dormsList.innerHTML = dorms.map(dorms => `
                    <div class="dorm-card">
                        <div class="dorm-title">
                            <h3 style="margin:0;">${dorms.name}</h3>
                            ${searchType === 'ai' ? `<span class="match-badge">${dorms.match_percentage}%</span>` : ''}
                        </div>
                        <hr class="dorm-divider" />
                        <div class="dorm-info">
                            <div class="dorm-info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>${dorms.location || 'Not specified'}</span>
                            </div>
                            <div class="dorm-info-item">
                                <i class="fas fa-door-open"></i>
                                <span>${dorms.number_of_rooms} rooms</span>
                            </div>
                            <div class="dorm-info-item">
                                <i class="fas fa-bed"></i>
                                <span>${dorms.room_types || 'Various types'}</span>
                            </div>
                            <div class="dorm-info-item">
                                <i class="fas fa-dollar-sign"></i>
                                <span>${dorms.rent ? `৳${dorms.rent}/month` : 'Contact for price'}</span>
                            </div>
                            <div class="dorm-info-item">
                                <i class="fas fa-venus-mars"></i>
                                <span>${dorms.gender_preference || 'Any'}</span>
                            </div>
                            <div class="dorm-info-item dorm-rating">
                                ${generateStars(dorms.avg_rating)}
                                <span style="color: #475569; margin-left: 5px;">(${parseFloat(dorms.avg_rating).toFixed(1)})</span>
                            </div>
                        </div>
                        ${dorms.facilities ? `
                            <div class="mb-3 dorm-info-item">
                                <i class="fas fa-concierge-bell" style="color: var(--primary); margin-right: 8px;"></i>
                                <span>${dorms.facilities}</span>
                            </div>
                        ` : ''}
                        <a href="/dorms/${dorms.id}" class="btn-view-dorm">
                            <i class="fas fa-eye me-2"></i>View Details
                        </a>
                    </div>
                `).join('');
            }
            
            resultsContainer.style.display = 'block';
            resultsContainer.scrollIntoView({ behavior: 'smooth' });
        }

        function generateStars(rating) {
            let stars = '';
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            
            for (let i = 0; i < fullStars; i++) {
                stars += '<i class="fas fa-star"></i>';
            }
            
            if (hasHalfStar) {
                stars += '<i class="fas fa-star-half-alt"></i>';
            }
            
            const emptyStars = 5 - Math.ceil(rating);
            for (let i = 0; i < emptyStars; i++) {
                stars += '<i class="far fa-star"></i>';
            }
            
            return stars;
        }
    </script>
</body>
</html>