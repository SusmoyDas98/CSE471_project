<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landlord Dashboard - DormMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landlord.css') }}">

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
    
    <button class="add-property-btn" id="addPropertyBtn" onclick="alert('Add new property...')">
        <i class="fas fa-plus"></i>
    </button>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Track if user has listed properties
        let hasListedProperties = false;
        
        // Function to switch tabs
        function switchTab(tabName) {
            // Only allow tab switching if properties exist
            if (!hasListedProperties) return;
            
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            const tabMap = {
                'all': 'allTab',
                'active': 'activeTab',
                'pending': 'pendingTab',
                'rented': 'rentedTab'
            };
            
            document.getElementById(tabMap[tabName]).classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }
        
        // Function to check and display appropriate content
        function checkPropertiesStatus() {
            const mainContent = document.getElementById('mainContent');
            
            if (!hasListedProperties) {
                // Show empty state
                mainContent.innerHTML = `
                    <div class="dashboard-header">
                        <h1>Property Management Dashboard</h1>
                        <p>Manage your listings, track tenants, and monitor property performance</p>
                    </div>
                    
                    <div class="empty-state" style="padding: 120px 20px;">
                        <i class="fas fa-building"></i>
                        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--text-primary); margin-bottom: 20px;">Start Listing Your Properties</h2>
                        <p style="font-size: 1.2rem; color: var(--text-secondary); max-width: 600px; margin: 0 auto 40px;">You haven't listed any properties yet. Create your first listing to start connecting with potential tenants and manage your rentals.</p>
                        <button onclick="listProperty()" style="background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; border: none; padding: 18px 48px; border-radius: 50px; font-size: 1.2rem; font-weight: 700; cursor: pointer; box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3); transition: all 0.3s;">
                            <i class="fas fa-plus-circle" style="margin-right: 10px;"></i>List Your Property
                        </button>
                    </div>
                `;
            } else {
                // Show full dashboard
                mainContent.innerHTML = getFullDashboardHTML();
            }
        }
        
        // Function to get full dashboard HTML
        function getFullDashboardHTML() {
            return `
                <div class="dashboard-header">
                    <h1>Property Management Dashboard</h1>
                    <p>Manage your listings, track tenants, and monitor property performance</p>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card success">
                        <div class="stat-icon success">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="stat-value">12</div>
                        <div class="stat-label">Total Properties</div>
                    </div>
                    
                    <div class="stat-card primary">
                        <div class="stat-icon primary">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-value">8</div>
                        <div class="stat-label">Active Listings</div>
                    </div>
                    
                    <div class="stat-card warning">
                        <div class="stat-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-value">3</div>
                        <div class="stat-label">Pending Approval</div>
                    </div>
                    
                    <div class="stat-card danger">
                        <div class="stat-icon danger">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="stat-value">7</div>
                        <div class="stat-label">Currently Rented</div>
                    </div>
                </div>
                
                <div class="tab-navigation">
                    <button class="tab-btn active" onclick="switchTab('all')">
                        <i class="fas fa-list me-2"></i>All Properties
                    </button>
                    <button class="tab-btn" onclick="switchTab('active')">
                        <i class="fas fa-check-circle me-2"></i>Active Listings
                    </button>
                    <button class="tab-btn" onclick="switchTab('pending')">
                        <i class="fas fa-clock me-2"></i>Pending Approval
                    </button>
                    <button class="tab-btn" onclick="switchTab('rented')">
                        <i class="fas fa-home me-2"></i>Rented Properties
                    </button>
                </div>
                
                <div id="allTab" class="tab-content active">
                    <div class="properties-grid">
                        ${getPropertyCards('all')}
                    </div>
                </div>
                
                <div id="activeTab" class="tab-content">
                    <div class="properties-grid">
                        ${getPropertyCards('active')}
                    </div>
                </div>
                
                <div id="pendingTab" class="tab-content">
                    <div class="properties-grid">
                        ${getPropertyCards('pending')}
                    </div>
                </div>
                
                <div id="rentedTab" class="tab-content">
                    <div class="properties-grid">
                        ${getPropertyCards('rented')}
                    </div>
                </div>
            `;
        }
        
        // Function to get property cards based on filter
        function getPropertyCards(filter) {
            const allProperties = [
                {type: 'active', title: 'Modern 2BR Apartment', address: '245 Campus Drive, University District', bed: 2, bath: 2, sqft: 850, price: '$1,200', gradient: 'linear-gradient(135deg, var(--primary-light), var(--accent))', icon: 'building'},
                {type: 'rented', title: 'Cozy Studio Near Campus', address: '128 College Avenue, Downtown', bed: 1, bath: 1, sqft: 500, price: '$800', gradient: 'linear-gradient(135deg, #10b981, #059669)', icon: 'home', tenant: 'Sarah Johnson'},
                {type: 'pending', title: 'Luxury 3BR Townhouse', address: '567 Oak Street, Suburban Area', bed: 3, bath: 2.5, sqft: 1200, price: '$1,800', gradient: 'linear-gradient(135deg, #f59e0b, #d97706)', icon: 'building'},
                {type: 'active', title: 'Shared 4BR House', address: '789 Pine Road, Campus Area', bed: 4, bath: 3, sqft: 1500, price: '$600', priceNote: '/person/month', gradient: 'linear-gradient(135deg, #8b5cf6, #7c3aed)', icon: 'home'},
                {type: 'rented', title: 'Penthouse Suite', address: '101 Skyline Boulevard, City Center', bed: 2, bath: 2, sqft: 1100, price: '$2,200', gradient: 'linear-gradient(135deg, #ec4899, #db2777)', icon: 'building', tenant: 'Michael Chen'},
                {type: 'pending', title: 'Garden View Apartment', address: '432 Maple Street, West Campus', bed: 1, bath: 1, sqft: 650, price: '$950', gradient: 'linear-gradient(135deg, #06b6d4, #0891b2)', icon: 'home'}
            ];
            
            const filtered = filter === 'all' ? allProperties : allProperties.filter(p => p.type === filter);
            
            return filtered.map(prop => `
                <div class="property-card">
                    <div class="property-image" style="background: ${prop.gradient};">
                        <i class="fas fa-${prop.icon}"></i>
                        <div class="property-status ${prop.type}">${prop.type.charAt(0).toUpperCase() + prop.type.slice(1)}</div>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">${prop.title}</h3>
                        <div class="property-address">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>${prop.address}</span>
                        </div>
                        <div class="property-details">
                            <div class="property-detail">
                                <div class="property-detail-value">${prop.bed}</div>
                                <div class="property-detail-label">Bedroom${prop.bed > 1 ? 's' : ''}</div>
                            </div>
                            <div class="property-detail">
                                <div class="property-detail-value">${prop.bath}</div>
                                <div class="property-detail-label">Bathroom${prop.bath > 1 ? 's' : ''}</div>
                            </div>
                            <div class="property-detail">
                                <div class="property-detail-value">${prop.sqft}</div>
                                <div class="property-detail-label">Sq Ft</div>
                            </div>
                        </div>
                        <div class="property-price">${prop.price}<span>${prop.priceNote || '/month'}</span></div>
                        ${prop.tenant ? `<div class="tenant-badge"><i class="fas fa-user"></i><span>${prop.tenant}</span></div>` : ''}
                        <div class="property-actions" style="${prop.tenant ? 'margin-top: 12px;' : ''}">
                            <button class="btn-property btn-edit" onclick="alert('Edit property...')">
                                <i class="fas fa-edit me-2"></i>Edit
                            </button>
                            <button class="btn-property btn-view" onclick="alert('View details...')">
                                <i class="fas fa-eye me-2"></i>View
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }
        
        // Function to list property
        function listProperty() {
            hasListedProperties = true;
            checkPropertiesStatus();
            // Show the add property button
            document.getElementById('addPropertyBtn').style.display = 'flex';
        }
        
        // Initialize on page load
        checkPropertiesStatus();
    </script>
</body>
</html>