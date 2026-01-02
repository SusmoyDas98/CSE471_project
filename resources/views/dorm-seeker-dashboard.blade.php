<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DormMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/DormSeeker.css') }}">

</head>
<body>
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>
    
    <div class="main-content" id="mainContent">
        <!-- Content will be dynamically loaded -->
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Track if user has joined a community (rented a dorm)
    const hasJoinedCommunity = @json($hasJoinedCommunity);
    const dormData = @json($dormData);
    const latestPost = @json($latestPost);
    const userName = @json($userName);
    const holidays = @json($holidays);

        

        

        
        // Function to calculate days until due date
        function getDaysUntilDue() {
            const dueDate = new Date(dormData.nextDueDate);;
            const today = new Date();
            const diffTime = dueDate - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays;
        }
        
        // Function to get due date class
        function getDueDateClass() {
            const days = getDaysUntilDue();
            if (days < 0) return 'overdue';
            if (days <= 5) return 'due-soon';
            return '';
        }
        
        // Function to check and display appropriate content
        function checkCommunityStatus() {
            const mainContent = document.getElementById('mainContent');
            
            if (!hasJoinedCommunity) {
                // Show empty state
                mainContent.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-home" style="font-size: 6rem; color: rgba(14, 165, 233, 0.2); margin-bottom: 30px;"></i>
                        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--text-primary); margin-bottom: 20px;">Welcome to DormMate!</h2>
                        <p style="font-size: 1.2rem; color: var(--text-secondary); max-width: 600px; margin: 0 auto 40px;">You haven't joined a dorm community yet. Once you rent a dorm, you'll automatically join your building's community and get access to important updates, payment information, and connect with your neighbors.</p>
                        <button onclick="joinCommunity()" style="background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; border: none; padding: 18px 48px; border-radius: 50px; font-size: 1.2rem; font-weight: 700; cursor: pointer; box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3); transition: all 0.3s;">
                            <i class="fas fa-search" style="margin-right: 10px;"></i>Find Your Dorm
                        </button>
                    </div>
                `;
            } else {
                // Show full dashboard
                const daysUntil = getDaysUntilDue();
                const dueDateClass = getDueDateClass();
                
                mainContent.innerHTML = `
                    <div class="dashboard-header">
                        <h1>Welcome back, ${userName ?? 'User'}!</h1>
                        <p>Here's your rental overview and latest community updates</p>
                    </div>
                    
                    <div class="community-section">
                        <div class="community-header">
                            <div class="community-title">
                                <div class="community-icon-badge">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h3>${dormData.communityName}</h3>
                                    <p><i class="fas fa-users me-1"></i>${dormData.totalMembers} members</p>
                                </div>
                            </div>
                            <a href="#" class="view-all-btn" onclick="alert('Opening full community forum...')">
                                <i class="fas fa-arrow-right me-2"></i>View All Posts
                            </a>
                        </div>
                        
                        <div style="margin-bottom: 16px;">
                            <h4 style="font-size: 1.1rem; color: var(--text-primary); margin-bottom: 16px;">
                                <i class="fas fa-star me-2" style="color: var(--gold);"></i>Latest Update
                            </h4>
                        </div>
                        
                        <div class="latest-post">
                            <div class="post-header">
                                <div class="post-author-avatar">${latestPost.authorInitial}</div>
                                <div class="post-author-info">
                                    <div class="post-author-name">${latestPost.author}</div>
                                    <div class="post-time"><i class="fas fa-clock me-1"></i>${latestPost.time}</div>
                                </div>
                            </div>
                            <div class="post-content">
                                <p>${latestPost.content}</p>
                            </div>
                            <div class="post-actions">
                                <div class="post-action">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>Like</span>
                                </div>
                                <div class="post-action">
                                    <i class="fas fa-comment"></i>
                                    <span>Comment</span>
                                </div>
                                <div class="post-action">
                                    <i class="fas fa-share"></i>
                                    <span>Share</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="rental-info-card">
                        <div class="rental-header">
                            <div class="rental-property">
                                <h2 class="property-name">${dormData.propertyName}</h2>
                                <div class="property-address">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>${dormData.address}</span>
                                </div>
                            </div>
                            <div class="rental-status">
                                <i class="fas fa-check-circle me-2"></i>Active Lease
                            </div>
                        </div>
                        
                        <div class="rental-details-grid">
                            <div class="rental-detail-item">
                                <div class="rental-detail-label">Monthly Rent</div>
                                <div class="rental-detail-value amount">${dormData.monthlyRent}</div>
                            </div>
                            <div class="rental-detail-item">
                                <div class="rental-detail-label">Next Payment Due</div>
                                <div class="rental-detail-value ${dueDateClass}">${dormData.nextDueDate}</div>
                                <p style="margin: 8px 0 0 0; font-size: 0.85rem; color: ${dueDateClass === 'due-soon' ? 'var(--warning)' : dueDateClass === 'overdue' ? 'var(--danger)' : 'var(--text-secondary)'};">
                                    ${daysUntil > 0 ? `${daysUntil} days remaining` : daysUntil === 0 ? 'Due today!' : `${Math.abs(daysUntil)} days overdue`}
                                </p>
                            </div>
                            <div class="rental-detail-item">
                                <div class="rental-detail-label">Lease Period</div>
                                <div class="rental-detail-value" style="font-size: 1rem; font-weight: 600;">${dormData.leaseStart}</div>
                                <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--text-secondary);">to ${dormData.leaseEnd}</p>
                            </div>
                        </div>
                        
                        <div class="landlord-info">
                            <div class="landlord-avatar">${dormData.landlordName.charAt(0)}</div>
                            <div class="landlord-details">
                                <h4>Your Landlord</h4>
                                <p>${dormData.landlordName}</p>
                                <p style="font-size: 0.85rem;"><i class="fas fa-envelope me-1"></i>${dormData.landlordEmail}</p>
                            </div>
                            <button class="contact-landlord-btn" onclick="alert('Opening message to ${dormData.landlordName}...')">
                                <i class="fas fa-comment-dots me-2"></i>Contact Landlord
                            </button>
                        </div>
                    </div>
                    
                    <div class="quick-actions">
                        <div class="action-card" onclick="alert('Opening payment portal...')">
                            <i class="fas fa-credit-card"></i>
                            <h4>Make Payment</h4>
                            <p>Pay rent or view payment history</p>
                        </div>
                        <div class="action-card" onclick="alert('Opening maintenance request...')">
                            <i class="fas fa-tools"></i>
                            <h4>Maintenance Request</h4>
                            <p>Report issues or track requests</p>
                        </div>
                        <div class="action-card" onclick="alert('Opening lease documents...')">
                            <i class="fas fa-file-contract"></i>
                            <h4>Lease Documents</h4>
                            <p>View your lease agreement</p>
                        </div>
                        <div class="action-card" onclick="alert('Opening community forum...')">
                            <i class="fas fa-users"></i>
                            <h4>Full Community Forum</h4>
                            <p>Browse all posts and discussions</p>
                        </div>
                    </div>

                    <!-- 📅 Calendar Section -->
                    <div class="rental-info-card" style="margin-top: 30px;">
                        <h2 class="property-name mb-3">📅 Calendar Preview</h2>
                        <p class="text-muted mb-3">
                            External calendar API integration (demo)
                        </p>

                        ${
                            holidays.length === 0
                            ? `<p class="text-danger">Calendar data unavailable.</p>`
                            : `
                                <ul class="list-group">
                                    ${holidays.map(h => `
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>${h.name}</span>
                                            <span class="badge bg-primary">${h.date}</span>
                                        </li>
                                    `).join('')}
                                </ul>
                            `
                        }
                    </div>

                `;
            }
        }
        
        // Function to join community (simulate renting a dorm)
        function joinCommunity() {
            hasJoinedCommunity = true;
            checkCommunityStatus();
        }
        
        // Initialize on page load
        checkCommunityStatus();
    </script>
</body>
</html>