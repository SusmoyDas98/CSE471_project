<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Your Perfect Roommate - DormLuxe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href='/css/search_dorm_mate.css'>

</head>
<body>
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>
    
    <div style="height: 100px;"></div>
    
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
            
            <div class="search-box">
                <input 
                    type="text" 
                    class="search-input" 
                    id="manualSearch"
                    placeholder="Search by name or interests (e.g., 'gaming', 'music', 'sports')..."
                >
                <button class="search-btn" onclick="performManualSearch()">
                    <i class="fas fa-search me-2"></i>Search
                </button>
            </div>
            
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
        
        <div class="results-container" id="resultsContainer">
            <div class="results-header">
                <h3 id="resultsTitle">Search Results</h3>
                <button class="filter-btn">
                    <i class="fas fa-filter me-2"></i>Filters
                </button>
            </div>
            
            <div class="loading" id="loadingSpinner" style="display: none;">
                <div class="spinner"></div>
                <p style="color: var(--text-secondary); font-weight: 600;">Finding your perfect matches...</p>
            </div>
            
            <div class="roommate-grid" id="roommateGrid">
                <!-- Results will be dynamically loaded here -->
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src = "/js/search_dorm_mate.js">
    
</body>
</html>