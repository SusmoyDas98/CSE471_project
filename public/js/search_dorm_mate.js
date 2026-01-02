    let isAIMode = false;
        
        // Sample data for demonstration
        const sampleProfiles = [
            {
                name: "Sarah Johnson",
                age: 20,
                major: "Computer Science",
                year: "Sophomore",
                interests: ["Gaming", "Coding", "Anime", "Music"],
                bio: "Tech enthusiast looking for a quiet study buddy who also loves late-night gaming sessions!",
                matchScore: 95,
                aiMatch: true
            },
            {
                name: "Emily Chen",
                age: 21,
                major: "Business Administration",
                year: "Junior",
                interests: ["Fitness", "Travel", "Photography", "Cooking"],
                bio: "Early bird who loves staying active. Looking for someone who values a clean space and good vibes.",
                matchScore: 88,
                aiMatch: true
            },
            {
                name: "Jessica Martinez",
                age: 19,
                major: "Psychology",
                year: "Freshman",
                interests: ["Reading", "Art", "Coffee", "Music"],
                bio: "Creative soul who loves quiet evenings with a good book and coffee. Seeking a respectful roommate.",
                matchScore: 82,
                aiMatch: false
            },
            {
                name: "Amanda Lee",
                age: 22,
                major: "Engineering",
                year: "Senior",
                interests: ["Sports", "Movies", "Gaming", "Tech"],
                bio: "Friendly and outgoing engineering student. Love watching sports and having movie nights!",
                matchScore: 79,
                aiMatch: false
            }
        ];
        
        function performManualSearch() {
            const searchQuery = document.getElementById('manualSearch').value;
            if (!searchQuery.trim()) {
                alert('Please enter a search term');
                return;
            }
            
            isAIMode = false;
            showResults('Manual Search Results', sampleProfiles.filter(p => !p.aiMatch));
        }
        
        function activateAIMode() {
            isAIMode = true;
            const resultsContainer = document.getElementById('resultsContainer');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const roommateGrid = document.getElementById('roommateGrid');
            
            resultsContainer.style.display = 'block';
            loadingSpinner.style.display = 'block';
            roommateGrid.innerHTML = '';
            
            // Scroll to results
            resultsContainer.scrollIntoView({ behavior: 'smooth' });
            
            // Simulate AI processing
            setTimeout(() => {
                loadingSpinner.style.display = 'none';
                showResults('AI Recommended Matches', sampleProfiles.filter(p => p.aiMatch));
            }, 2000);
        }
        
        function showResults(title, profiles) {
            const resultsContainer = document.getElementById('resultsContainer');
            const resultsTitle = document.getElementById('resultsTitle');
            const roommateGrid = document.getElementById('roommateGrid');
            
            resultsTitle.textContent = title;
            resultsContainer.style.display = 'block';
            
            roommateGrid.innerHTML = profiles.map((profile, index) => `
                <div class="roommate-card">
                    ${isAIMode && profile.aiMatch ? `<div class="ai-match-badge"><i class="fas fa-star me-1"></i>AI Match</div>` : ''}
                    <div class="profile-header">
                        <div class="profile-avatar">${profile.name.charAt(0)}</div>
                        <div class="profile-info">
                            <h4>${profile.name}</h4>
                            <div class="profile-meta">
                                <span><i class="fas fa-graduation-cap me-1"></i>${profile.major}</span>
                                <span><i class="fas fa-calendar me-1"></i>${profile.year}</span>
                            </div>
                            ${isAIMode && profile.aiMatch ? `<span class="match-score"><i class="fas fa-heart me-1"></i>${profile.matchScore}% Match</span>` : ''}
                        </div>
                    </div>
                    <div class="interests">
                        ${profile.interests.map(interest => `<span class="interest-tag"><i class="fas fa-tag me-1"></i>${interest}</span>`).join('')}
                    </div>
                    <p class="profile-bio">${profile.bio}</p>
                    <div class="card-actions">
                        <button class="btn-request" onclick="sendRequest('${profile.name}')">
                            <i class="fas fa-user-plus me-2"></i>Send Request
                        </button>
                        <button class="btn-message" onclick="sendMessage('${profile.name}')">
                            <i class="fas fa-comment me-2"></i>Message
                        </button>
                    </div>
                </div>
            `).join('');
            
            // Scroll to results
            resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        function sendRequest(name) {
            alert(`Roommate request sent to ${name}!`);
        }
        
        function sendMessage(name) {
            alert(`Opening message conversation with ${name}...`);
        }
        
        // Allow Enter key to trigger search
        document.getElementById('manualSearch').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performManualSearch();
            }
        });
    